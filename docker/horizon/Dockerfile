FROM php:8.4-fpm-alpine


RUN apk add supervisor oniguruma-dev && \
    mkdir -p /var/log/supervisor


RUN apk add  pcre-dev $PHPIZE_DEPS \
&& pecl install redis \
&& docker-php-ext-enable redis.so 
RUN docker-php-ext-install pcntl pdo pdo_mysql mbstring  
RUN docker-php-ext-enable pcntl

COPY --chown=www-data:www-data . /var/www/html


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

COPY horizon.conf /etc/supervisor/conf.d/horizon.conf
