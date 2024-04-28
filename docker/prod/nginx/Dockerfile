FROM ghcr.io/romeronet/base-images/nginx-php-prod:latest

ADD docker/prod/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN chown -R 1000:1000 /app

ADD public /app/public
