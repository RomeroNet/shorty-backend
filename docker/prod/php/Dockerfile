FROM composer:2.6.5 AS dependencies

ADD . /app

WORKDIR /app

RUN composer install --no-dev --optimize-autoloader

FROM ghcr.io/romeronet/base-images/php-prod:latest

COPY --from=dependencies --chown=1000:1000 /app /app

WORKDIR /app
