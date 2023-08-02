FROM php:8.2.8-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && apt-get upgrade -y \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install bcmath pdo pdo_mysql

COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer
