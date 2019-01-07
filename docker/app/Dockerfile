FROM php:7.2-fpm

MAINTAINER Paco Orozco <paco@pacoorozco.info>

# Install "libmcrypt-dev, "libpng-dev", "zlib1g-dev".
RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests \
        libpng-dev \
        zlib1g-dev

# Install the PHP needed extentions
RUN docker-php-ext-install \
    gd \
    mbstring \
    pdo_mysql \
    zip

# Clean up
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && rm /var/log/lastlog /var/log/faillog

COPY ./docker/app/laravel.ini /usr/local/etc/php/conf.d

RUN usermod -u 1000 www-data

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
