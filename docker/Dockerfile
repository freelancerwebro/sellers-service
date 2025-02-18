FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer global require laravel/installer

# Set environment variable for Composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"

# Copy Laravel files
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Set environment variable for Composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"

# Install Laravel dependencies
RUN composer install

# Expose port
EXPOSE 9000

# Start PHP-FPM and run migrations
CMD php artisan migrate --force && php-fpm