FROM composer:2
FROM php:8.0-cli as base
WORKDIR /var/www

ENV UID=1000
ENV GID=1000

# Setup to install stuff
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get -y install unzip libzip-dev make git \
	&& docker-php-ext-install zip \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache

# Fetch sources
COPY containers ./containers
COPY benchmark ./benchmark
COPY src ./src
COPY ./phpbench.json ./Makefile ./composer.json ./composer.lock ./generate_services.php ./service_template.php ./

ARG SERVICES=100
ENV SERVICES=${SERVICES}
RUN make prepare

ENV APP_ENV=prod

# Setup PHP + Apache
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && echo "opcache.enable=1" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.enable_cli=1" >> "$PHP_INI_DIR/php.ini" \
    && echo "opcache.validate_timestamp=0" >> "$PHP_INI_DIR/php.ini"
