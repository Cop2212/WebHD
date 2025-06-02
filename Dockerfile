FROM php:8.2-apache

RUN apt-get update && apt-get install -y libzip-dev unzip libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring xml \
    && a2enmod rewrite

COPY . /var/www
WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

RUN cp .env.example .env && php artisan key:generate \
    && chown -R www-data:www-data storage bootstrap/cache /var/www \
    && chmod -R 755 storage bootstrap/cache

# Replace apache config
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
