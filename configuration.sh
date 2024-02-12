#! /bin/bash
composer install
chmod 777 -R storage/
php artisan key:generate
php artisan migrate
php artisan config:cache
php artisan config:clear
php artisan cache:clear
php artisan queue:restart
php artisan l5-swagger:generate
#php artisan migrate
