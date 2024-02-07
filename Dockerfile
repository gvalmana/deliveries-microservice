FROM php:8.1-fpm
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip
#Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html
COPY .env.example .env
COPY php.ini /etc/php/8.1/fpm/php.ini
COPY site.conf /etc/nginx/sites-available/default
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --quiet
COPY . .
RUN composer dump-autoload
#RUN php artisan migrate
RUN php artisan key:generate
RUN chmod o+w ./storage/ -R
RUN chown www-data:www-data -R ./storage
RUN chmod o+w /var/www/html/public
