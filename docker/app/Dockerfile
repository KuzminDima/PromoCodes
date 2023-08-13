FROM php:8.1-alpine

WORKDIR /var/www

RUN apk add --no-cache \
		$PHPIZE_DEPS \
		openssl-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && pecl install xdebug-3.1.2 \
    && docker-php-ext-enable xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php", "-S", "0.0.0.0:80", "-t", "./public", "./public/web.php"]