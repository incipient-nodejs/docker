# Start from official PHP image with FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy only composer files (this step is cacheable)
COPY composer.json composer.lock ./

# Install PHP dependencies (cached unless composer files change)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Now copy the rest of the application
COPY . .

# Set permissions (adjust for your app’s needs)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Expose port 9000 (Laravel dev server)
EXPOSE 9000

# Start Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
