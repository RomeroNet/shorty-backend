FROM nginx:mainline

RUN useradd -u 1000 laravel

RUN touch /var/run/nginx.pid

RUN chown 1000 /var/cache/nginx \
    /var/run/nginx.pid

USER 1000

COPY default.conf /etc/nginx/conf.d/default.conf
