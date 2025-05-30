# ---- Base PHP Image ----
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# ---- System Dependencies ----
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

# ---- Install Composer ----
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---- Copy composer files first for caching ----
COPY composer.json composer.lock ./

# ---- Install PHP dependencies ----
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# ---- Copy full Laravel application ----
COPY . .

# ---- Permissions ----
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# ---- Expose port ----
EXPOSE 9000

# ---- Run Laravel development server ----
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
