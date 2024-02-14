FROM php:8.1.0-fpm
RUN docker-php-ext-install mbstring zip exif pcntl
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install gd

RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    dnsutils \
    librdkafka-dev \
    supervisor

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN mkdir -p "/etc/supervisor/logs"

COPY ./supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]
