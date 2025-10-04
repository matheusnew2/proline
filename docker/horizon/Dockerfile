FROM php:8.4-fpm-alpine

ARG WWWGROUP
RUN apk add supervisor oniguruma-dev && \
    mkdir -p /var/log/supervisor


RUN apk add  pcre-dev $PHPIZE_DEPS \
&& pecl install redis \
&& docker-php-ext-enable redis.so 
RUN docker-php-ext-install pcntl pdo pdo_mysql mbstring  
RUN docker-php-ext-enable pcntl

COPY --chown=www-data:www-data . /var/www/html

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer install

RUN apk add --no-cache bash && \
    addgroup -g $WWWGROUP sail && \
    adduser -D -u 1337 -G sail -s /bin/bash sail


COPY ./docker/horizon/horizon.conf /etc/supervisor/conf.d/horizon.conf


RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache


