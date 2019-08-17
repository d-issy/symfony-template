FROM php:7.1-fpm-alpine

RUN apk add --no-cache \
    git \
    vim \
    curl \
    icu-dev \
&& apk add --no-cache --update --virtual buildOps \
    autoconf \
    build-base \
&& docker-php-ext-install -j $(nproc) \
    intl \
    mbstring \
    opcache \
    pcntl \
    pdo \
    pdo_mysql \
&& yes '' | pecl install apcu xdebug \
&& docker-php-ext-enable apcu \
&& apk del buildOps \
&& rm -rf /tmp/*

COPY php.ini /usr/local/etc/php/conf.d
WORKDIR /app