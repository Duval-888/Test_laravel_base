FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Créer SQLite aux deux endroits possibles
RUN mkdir -p /var/data && touch /var/data/database.sqlite
RUN touch /var/www/database/database.sqlite

RUN chmod -R 777 storage bootstrap/cache database
RUN chmod 777 /var/data/database.sqlite

# Créer le .env
RUN echo "APP_NAME=ForumEnLigne" > .env \
    && echo "APP_ENV=production" >> .env \
    && echo "APP_KEY=base64:zCWFC2ZoDxPyV4C01clsSJLTOk9FTFR/DU6l6wZ2Q4o=" >> .env \
    && echo "APP_DEBUG=false" >> .env \
    && echo "APP_URL=https://forum-en-ligne.onrender.com" >> .env \
    && echo "DB_CONNECTION=sqlite" >> .env \
    && echo "DB_DATABASE=/var/data/database.sqlite" >> .env \
    && echo "CACHE_DRIVER=file" >> .env \
    && echo "SESSION_DRIVER=file" >> .env \
    && echo "QUEUE_CONNECTION=sync" >> .env \
    && echo "FILESYSTEM_DISK=local" >> .env \
    && echo "LOG_CHANNEL=stack" >> .env \
    && echo "LOG_LEVEL=debug" >> .env

RUN php artisan config:clear
RUN php artisan route:clear  
RUN php artisan view:clear

EXPOSE 10000

CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=10000