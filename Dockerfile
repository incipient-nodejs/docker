# Set base image
FROM php:8.2-fpm

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
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create minimal composer.json if it doesn't exist
RUN if [ ! -f composer.json ]; then \
    echo '{}' > composer.json && \
    composer config name "temp/project" && \
    composer config description "Temporary project" && \
    composer config minimum-stability "dev" && \
    composer config prefer-stable true; \
    fi

# Install Laravel dependencies
RUN composer require laravel/framework --no-scripts --no-autoloader && \
    composer require laravel/sanctum --no-scripts --no-autoloader && \
    composer require laravel/tinker --no-scripts --no-autoloader

# Copy the rest of the application files
COPY . /var/www

# Finish composer installation
RUN composer dump-autoload --optimize && \
    composer run-script post-install-cmd

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Expose port 9000
EXPOSE 9000

# Start Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]