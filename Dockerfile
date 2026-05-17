FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN touch /var/www/database/database.sqlite

RUN chmod -R 777 storage bootstrap/cache database

RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

EXPOSE 10000

CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=10000