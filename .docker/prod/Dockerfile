FROM webmagicagency/laravel6.x_php7.3_apache

MAINTAINER Yevhen Saienko

# Copy custom vhost apllying
COPY ./.docker/prod/vhost.conf /etc/apache2/sites-available/000-default.conf

# Install certbot
RUN apt-get update && apt-get install -y certbot python-certbot-apache
