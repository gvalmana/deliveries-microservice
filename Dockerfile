FROM php:8.2-cli
RUN docker-php-source extract \
	# do important things \
	&& docker-php-source delete
WORKDIR /var/www/html
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
COPY .env.example .env
RUN composer dump-autoload
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan config:cache
#RUN php artisan migrate
RUN php artisan key:generate
RUN chmod 7777 storage/ -R -v
RUN chown www-data:www-data -R storage
RUN chmod o+w /var/www/html/public
