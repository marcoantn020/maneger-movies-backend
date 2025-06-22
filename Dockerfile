FROM php:8.3-fpm

ARG user=marco
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git curl wget \
    build-essential pkg-config libssl-dev \
    libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
    zip unzip libzip-dev \
    && docker-php-ext-configure gd \
        --with-jpeg --with-freetype --with-webp \
    && docker-php-ext-install \
        pdo_mysql mbstring exif pcntl bcmath gd sockets \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN useradd -m -u ${uid} -G www-data ${user} \
    && mkdir -p /var/www \
    && chown ${user}:${user} /var/www

COPY --chown=${user}:${user} composer.json composer.lock /var/www/

USER ${user}
WORKDIR /var/www
RUN composer install --no-interaction --optimize-autoloader --no-dev

COPY --chown=${user}:${user} . .

USER root
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

USER ${user}
RUN if [ ! -f .env ]; then \
        cp .env.example .env && \
        php artisan key:generate; \
    fi

CMD sh -c "
    php artisan migrate --seed && \
    php artisan storage:link && \
    php-fpm
"

EXPOSE 9000
