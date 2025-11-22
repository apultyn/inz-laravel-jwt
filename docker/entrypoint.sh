#!/bin/sh

php artisan migrate

php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ReviewSeeder

php-fpm &

exec nginx -g 'daemon off;'