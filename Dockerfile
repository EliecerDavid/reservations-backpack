FROM php:8.1-fpm

RUN apt-get update

RUN apt-get install -y \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql zip xml gd

# Get composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer
