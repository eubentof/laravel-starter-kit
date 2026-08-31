FROM php:8.4-fpm-alpine AS php-base

RUN apk add --no-cache $PHPIZE_DEPS bash curl git icu-dev libpng-dev libzip-dev linux-headers oniguruma-dev postgresql-dev unzip \
    && docker-php-ext-install bcmath intl mbstring opcache pcntl pdo_pgsql zip \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY docker/php/php.ini /usr/local/etc/php/conf.d/starter.ini

FROM php-base AS php-dev
CMD ["php-fpm"]

FROM php-base AS node-dev
RUN apk add --no-cache nodejs npm
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0", "--port", "5174"]

FROM php-base AS php-production
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-scripts
COPY . .
RUN composer dump-autoload --optimize --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache
USER www-data
CMD ["php-fpm"]
