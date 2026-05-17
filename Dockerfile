FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Créer le .env directement
RUN echo "APP_NAME=ForumEnLigne" > .env \
    && echo "APP_ENV=production" >> .env \
    && echo "APP_KEY=base64:zCWFC2ZoDxPyV4C01clsSJLTOk9FTFR/DU6l6wZ2Q4o=" >> .env \
    && echo "APP_DEBUG=false" >> .env \
    && echo "APP_URL=https://forum-laravel.onrender.com" >> .env \
    && echo "DB_CONNECTION=sqlite" >> .env \
    && echo "DB_DATABASE=/var/www/database/database.sqlite" >> .env \
    && echo "CACHE_DRIVER=file" >> .env \
    && echo "SESSION_DRIVER=file" >> .env \
    && echo "QUEUE_CONNECTION=sync" >> .env \
    && echo "FILESYSTEM_DISK=local" >> .env \
    && echo "LOG_CHANNEL=stack" >> .env \
    && echo "LOG_LEVEL=debug" >> .env

RUN touch /var/www/database/database.sqlite

RUN chmod -R 777 storage bootstrap/cache database

RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

EXPOSE 10000

CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=10000