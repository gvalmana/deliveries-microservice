FROM gvalmana/micro-service-deliveries-php

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && apt-get update \
    && apt-get install -y --no-install-recommends supervisor

ADD ./laravel-workers.conf /etc/supervisor/conf.d/

CMD ["supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]
