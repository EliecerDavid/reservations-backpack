FROM php:8.1-fpm

RUN apt-get update

RUN apt-get install -y \
    zip

RUN docker-php-ext-install pdo pdo_mysql

# Get composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer
