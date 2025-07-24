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

# Set environment variable to allow Composer as superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install dependencies - now that everything is in require, this should work clean
RUN composer install --no-dev --optimize-autoloader --no-scripts

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

# Run composer dump-autoload with superuser permission
RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize --no-scripts

# Replace the existing RUN command for start.sh with this:
RUN echo '#!/bin/bash\n\
sleep 2\n\
\n\
if [ ! -f .env ]; then\n\
    cp .env.example .env 2>/dev/null || echo "No .env.example found, creating basic .env"\n\
    echo "APP_NAME=Laravel" > .env\n\
    echo "APP_ENV=production" >> .env\n\
    echo "APP_DEBUG=false" >> .env\n\
    echo "APP_URL=${APP_URL:-http://localhost}" >> .env\n\
fi\n\
\n\
# Always write Render-provided APP_KEY to .env\n\
if [ -n "$APP_KEY" ]; then\n\
    sed -i "s/^APP_KEY=.*/APP_KEY=$APP_KEY/" .env || echo "APP_KEY=$APP_KEY" >> .env\n\
fi\n\
\n\
# Generate key only if not set\n\
if ! grep -q "^APP_KEY=[^[:space:]]" .env; then\n\
    php artisan key:generate --force || true\n\
fi\n\
\n\
php artisan migrate --force || echo "Migration failed or tables already exist - continuing"\n\
\n\
php artisan storage:link || true\n\
\n\
php artisan config:cache || true\n\
php artisan route:cache || true\n\
php artisan view:cache || true\n\
\n\
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}\n' > /var/www/start.sh

# Make startup script executable
RUN chmod +x /var/www/start.sh

# Expose port
EXPOSE 8000

# Use the startup script
CMD ["/var/www/start.sh"]