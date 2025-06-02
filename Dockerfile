FROM php:8.2-apache

# Cài extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql zip mbstring

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy source code
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Laravel storage link, permissions...
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
