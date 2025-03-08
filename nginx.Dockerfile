FROM nginx:latest

COPY ./docker/nginx/conf.d/app.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

CMD ["nginx", "-g", "daemon off;"]

