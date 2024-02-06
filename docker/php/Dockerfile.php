FROM php:8.1-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
build-essential \
libpng-dev \
libjpeg62-turbo-dev \
libonig-dev \
libfreetype6-dev \
libwebp-dev \
zlib1g-dev \
libzip-dev \
libcurl4-openssl-dev \
zip \
curl \
unzip \
git \
supervisor \
nginx

# Устанавливаем Node.js версии 20
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath opcache
RUN pecl install apcu && docker-php-ext-enable apcu

# Устанавливаем Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

CMD ["php-fpm"]

EXPOSE 9000
