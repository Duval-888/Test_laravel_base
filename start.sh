#!/bin/bash
mkdir -p /var/www/database
touch /var/www/database/database.sqlite
chmod 777 /var/www/database/database.sqlite
php artisan config:clear
php artisan migrate --force
php artisan db:seed --force
php artisan serve --host=0.0.0.0 --port=10000