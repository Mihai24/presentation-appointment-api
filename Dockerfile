FROM php:8.2-fpm-alpine AS app_php

ENV APP_ENV=dev

WORKDIR /var/www/api

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
		$PHPIZE_DEPS \
	;

RUN set -eux; \
    install-php-extensions \
    	intl \
    	zip \
		opcache \
        pdo_mysql \
    ;

RUN pecl install apcu && docker-php-ext-enable apcu

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .

RUN rm -Rf docker/

CMD ["php-fpm"]
EXPOSE 9000
