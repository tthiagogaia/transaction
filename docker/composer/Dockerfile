FROM composer:latest

WORKDIR /var/www

RUN apk add postgresql-dev \
    && docker-php-ext-install bcmath pdo_pgsql pcntl \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && apk del -f .build-deps

