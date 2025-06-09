FROM php:8.2-fpm

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    libonig-dev \
    zlib1g-dev \
    libpng-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    # Install PHP Redis extension
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel app (no vendor or lock file)
COPY . .

# Make Laravel folders writable
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    storage/logs bootstrap/cache \
    && chmod -R 755 storage bootstrap/cache

# Run composer update and confirm vendor is created
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && test -f vendor/autoload.php || (echo "❌ composer failed!" && exit 1)
    
# Expose port for artisan
EXPOSE 9000

# Start Laravel app
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
