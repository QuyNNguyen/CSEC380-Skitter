FROM php:7.0-apache

RUN docker-php-source extract && \ 
    docker-php-ext-install mysqli \
    && docker-php-source delete

ADD ./ /var/www/html/
