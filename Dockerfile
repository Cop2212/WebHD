FROM php:8.2-apache

# Cài PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring

# Bật mod_rewrite cho Laravel
RUN a2enmod rewrite

# Sửa DocumentRoot về /var/www/html/public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Copy mã nguồn
COPY . /var/www/html

# Set quyền
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Laravel yêu cầu thư mục storage và bootstrap/cache phải ghi được
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache
