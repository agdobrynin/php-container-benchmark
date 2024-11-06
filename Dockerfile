FROM composer:2
FROM php:8.1-cli as base
WORKDIR /var/www

# Setup to install stuff
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get -y install unzip libzip-dev make git \
	&& docker-php-ext-install zip \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache

RUN groupmod -g 1000 www-data
RUN useradd -u 1000 -ms /bin/bash -g www-data dockeruser
RUN chown -R dockeruser:www-data /var/www

# Setup PHP + Apache
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && echo "opcache.enable=1" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.enable_cli=1" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.validate_timestamp=0" >> "$PHP_INI_DIR/php.ini"

USER dockeruser

ARG SERVICES=100
ENV SERVICES=${SERVICES}
ENV APP_ENV=prod
