FROM php:7.2-apache

RUN docker-php-source extract && \ 
    docker-php-ext-install mysqli \
    && docker-php-source delete

COPY php.ini /usr/local/etc/php
ADD ./ /var/www/html/
