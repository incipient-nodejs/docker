# Set base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
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

# Copy existing application directory contents
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Run composer install to install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Run migrations during startup
COPY docker.db.migration.sh /usr/local/bin/docker.db.migration.sh
RUN chmod +x /usr/local/bin/docker.db.migration.sh

# Expose port 9000
EXPOSE 9000

# Start Laravel dev server
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
CMD ["sh", "-c", "/usr/local/bin/docker.db.migration.sh && php artisan serve --host=0.0.0.0 --port=9000"]
