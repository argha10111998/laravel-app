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

# Copy the entire application first
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

# Install dependencies with full context
RUN composer install --no-dev --optimize-autoloader || \
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Create a simple startup script
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
# Wait for environment\n\
sleep 2\n\
\n\
# Basic Laravel setup\n\
php artisan key:generate --force || echo "Key generation failed"\n\
php artisan storage:link || echo "Storage link failed"\n\
\n\
# Try migrations\n\
php artisan migrate --force || echo "Migration failed - continuing"\n\
\n\
# Start server\n\
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}\n' > /var/www/start.sh

# Make startup script executable
RUN chmod +x /var/www/start.sh

# Expose port
EXPOSE 8000

# Use the startup script
CMD ["/var/www/start.sh"]