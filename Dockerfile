FROM php:8.2-cli

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies without scripts to avoid configuration issues
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-plugins

# Copy the rest of the application
COPY . /var/www

# Create necessary directories and set permissions
RUN mkdir -p storage/app/public \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Run composer dump-autoload without triggering package discovery
RUN composer dump-autoload --optimize --no-scripts

# Create a startup script
RUN echo '#!/bin/bash\n\
# Wait a moment for environment to be ready\n\
sleep 2\n\
\n\
# Clear any cached config first\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
\n\
# Try to install missing dependencies if needed\n\
if [ "$APP_ENV" = "production" ]; then\n\
    composer install --no-dev --optimize-autoloader --no-scripts || true\n\
fi\n\
\n\
# Generate app key if not exists\n\
php artisan key:generate --force || true\n\
\n\
# Run migrations (skip if Sanctum is causing issues)\n\
php artisan migrate --force || echo "Migration failed, continuing..."\n\
\n\
# Create storage link\n\
php artisan storage:link || true\n\
\n\
# Skip caching if there are configuration issues\n\
php artisan config:cache || echo "Config cache failed, running without cache"\n\
\n\
# Start the server\n\
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}\n' > /var/www/start.sh

# Make startup script executable
RUN chmod +x /var/www/start.sh

# Expose port
EXPOSE 8000

# Use the startup script
CMD ["/var/www/start.sh"]