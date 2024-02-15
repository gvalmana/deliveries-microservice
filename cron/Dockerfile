FROM php:8.1.0-fpm

RUN apt-get update && apt-get install -y cron libpq-dev libzip-dev zip unzip curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmagickwand-dev \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pgsql pdo_pgsql zip\
    && docker-php-ext-enable opcache

# Install redis
RUN pecl install -o -f redis \
  &&  rm -rf /tmp/pear \
  &&  docker-php-ext-enable redis

# Add docker custom crontab
ADD my_laravel_docker_crontab /etc/cron.d/my_laravel_docker_crontab

# Update the crontab file permission
RUN chmod 0644 /etc/cron.d/my_laravel_docker_crontab

# Specify crontab file for running
RUN crontab /etc/cron.d/my_laravel_docker_crontab

# execute crontab
CMD ["cron", "-f"]
