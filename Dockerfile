# # Set base image
# FROM php:8.2-fpm

# # Set working directory
# WORKDIR /var/www

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip \
#     libzip-dev \
#     libpq-dev \
#     && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# # Install Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # Copy existing application directory contents
# COPY . /var/www

# # Set permissions
# RUN chown -R www-data:www-data /var/www \
#     && chmod -R 755 /var/www

# # Expose port 9000
# EXPOSE 9000

# # Start Laravel dev server
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]



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
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
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
