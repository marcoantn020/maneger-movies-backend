FROM php:8.3-fpm

ARG user=marco
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git curl wget zsh \
    build-essential pkg-config libssl-dev \
    libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
    zip unzip libzip-dev \
 && docker-php-ext-configure gd \
      --with-jpeg --with-freetype --with-webp \
 && docker-php-ext-install \
      pdo_mysql mbstring exif pcntl bcmath gd sockets \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -m -u ${uid} -s /usr/bin/zsh -G www-data ${user}

USER ${user}

USER root

WORKDIR /var/www
COPY --chown=${user}:${user} . .

COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

USER ${user}
CMD ["php-fpm"]
