FROM php:8.1-fpm

# Get composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer
