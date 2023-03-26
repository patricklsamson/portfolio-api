FROM php:8.0-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

COPY . .

RUN apk update && apk add --no-cache postgresql-dev zlib-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && composer install --no-dev \
    && rm composer-setup.php

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
