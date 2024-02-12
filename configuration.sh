#! /bin/bash
php artisan config:cache
php artisan config:clear
php artisan cache:clear
php artisan queue:restart
php artisan l5-swagger:generate
chmod -R 777 storage/*
#php artisan migrate
