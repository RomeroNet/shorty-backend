FROM php:8.1-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install bcmath

COPY --from=composer /usr/bin/composer /usr/bin/composer
