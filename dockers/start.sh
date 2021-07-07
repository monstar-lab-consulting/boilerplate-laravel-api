#!/bin/bash
# php artisan config:cache
composer self-update --2
composer install --no-interaction
composer dump-autoload --optimize
php artisan migrate --force
php artisan route:cache
service php8.0-fpm stop
service supervisor start
chmod -R 777 storage/
/usr/sbin/nginx
/usr/sbin/php-fpm8.0 -O
