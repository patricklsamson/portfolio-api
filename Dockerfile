FROM php:8.0-fpm-alpine

WORKDIR /app

COPY . /app

RUN apk update && apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && composer install --no-dev \
    && rm composer-setup.php

EXPOSE {{PORT}}

CMD ["php", "-S", "0.0.0.0:{{PORT}}", "-t", "public"]
