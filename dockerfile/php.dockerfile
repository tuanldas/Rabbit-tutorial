FROM php:8.0-apache

RUN apt-get update && apt-get install -y libmcrypt-dev \
    libmagickwand-dev --no-install-recommends \
    && docker-php-source extract \
    && docker-php-source delete \
    && docker-php-ext-configure gd --with-freetype \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y \
        libzip-dev \
        zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
