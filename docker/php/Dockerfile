# ---------- base ----------
FROM php:8.2-fpm-alpine AS base

WORKDIR /var/www/html

# System deps
RUN apk add --no-cache \
        bash \
        git \
        curl \
        unzip \
        icu-dev \
        oniguruma-dev \
        libzip-dev \
        mysql-client

RUN docker-php-ext-install \
        pdo_mysql \
        intl \
        mbstring \
        zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP config
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-custom.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# ---------- dev ----------
FROM base AS dev
RUN apk add --no-cache linux-headers $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# ---------- prod ----------
FROM base AS prod
# (en prod NO montas volumen; copias el código en el build)
COPY . /var/www/html

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache