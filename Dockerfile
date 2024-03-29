FROM php:7-fpm

RUN apt-get update \
    && apt-get install -y libmcrypt-dev mysql-client \
    && docker-php-ext-install pdo_mysql

RUN pecl install mcrypt-1.0.1 \
    && docker-php-ext-enable mcrypt
