FROM nginx:latest

# Copy configuration to a template location
COPY ./docker/nginx/conf.d/app.conf /etc/nginx/conf.d/app.conf.template

# Use shell form of ENTRYPOINT to perform logic without a separate file
ENTRYPOINT if [ ! -f /etc/nginx/conf.d/default.conf ]; then cp /etc/nginx/conf.d/app.conf.template /etc/nginx/conf.d/default.conf; fi && nginx -g 'daemon off;'

WORKDIR /var/www

# Empty CMD as we've included the nginx command in ENTRYPOINT
CMD [""]

