# Sử dụng PHP 8.2 với FPM
FROM php:8.2-fpm

# Cài các extensions cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql zip

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Tạo storage link nếu cần (bạn có thể bật lên nếu dùng Storage)
# RUN php artisan storage:link

# Thiết lập quyền (nếu cần)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
