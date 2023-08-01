FROM composer:2.5.8 AS dependencies

ADD . /app

WORKDIR /app

RUN composer install --no-dev --optimize-autoloader

FROM php:8.2.8-fpm

RUN apt-get update && apt-get upgrade -y \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install bcmath

COPY --from=dependencies --chown=1000:1000 /app /app

WORKDIR /app
