FROM php:8.1.0-fpm

ENV APP_ROOT=/var/www/html QUEUE_DRIVER=database NUM_PROCS=4 OPTIONS=

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && apt-get update \
    && apt-get install -y --no-install-recommends supervisor

ADD ./laravel-workers.conf /etc/supervisor/conf.d/

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
