FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    bash \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    libonig-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    && apt-get clean

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory inside container
WORKDIR /var/www

# Copy app code (but no vendor or composer.lock expected)
COPY . .

# Create Laravel required directories
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# Generate vendor/ and composer.lock inside image
RUN composer update --no-dev --optimize-autoloader --no-interaction

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]

# Expose port for Laravel dev server
EXPOSE 9000