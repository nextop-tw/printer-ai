FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libwebp-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql gd bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# imagick 需要時再手動安裝：
# apt-get install -y libmagickwand-dev && pecl install imagick && docker-php-ext-enable imagick

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
