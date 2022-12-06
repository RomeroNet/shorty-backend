FROM nginx:mainline

RUN touch /var/run/nginx.pid

RUN chown 1000 /var/cache/nginx \
    /var/run/nginx.pid

USER 1000

ADD default.conf /etc/nginx/conf.d/default.conf
