FROM composer:2.5.5 AS dependencies

ADD . /app

WORKDIR /app

RUN composer install --no-dev --optimize-autoloader

FROM php:8.2.5-fpm

RUN docker-php-ext-install bcmath

COPY --from=dependencies --chown=1000:1000 /app /app

WORKDIR /app
