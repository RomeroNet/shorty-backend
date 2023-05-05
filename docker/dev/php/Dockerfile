FROM php:8.2.5-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install bcmath

COPY --from=composer:2.5.5 /usr/bin/composer /usr/bin/composer
