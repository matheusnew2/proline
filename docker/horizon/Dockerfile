FROM php:8.4-fpm-alpine

ARG WWWGROUP
RUN apk add supervisor oniguruma-dev && \
    mkdir -p /var/log/supervisor


RUN apk add  pcre-dev $PHPIZE_DEPS \
&& pecl install redis \
&& docker-php-ext-enable redis.so 
RUN docker-php-ext-install pcntl pdo pdo_mysql mbstring  
RUN docker-php-ext-enable pcntl


WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer install

RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail
RUN git config --global --add safe.directory /var/www/html

COPY ./docker/horizon/horizon.conf /etc/supervisor/conf.d/horizon.conf
