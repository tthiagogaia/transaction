FROM php:8.0-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install bcmath pdo_pgsql pcntl \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && apk del -f .build-deps
