FROM php:8.4-fpm

RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libicu-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html