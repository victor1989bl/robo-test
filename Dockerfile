FROM php:7.4.15-fpm-alpine3.12 as base-php-pfm

RUN apk --no-cache add \
        libaio \
        libnsl \
        libzip \
        freetype \
        libjpeg-turbo \
        libldap \
        git

RUN apk --no-cache  --virtual .ext-build-deps add \
        gcc \
        libzip-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        openldap-dev && \
     docker-php-ext-configure gd --with-freetype --with-jpeg && \
     docker-php-ext-install -j$(nproc) ldap mysqli pdo_mysql gd zip opcache exif && \
     apk del .ext-build-deps

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# зависимости php
FROM base-php-pfm as deps-backend

ADD ./composer.json /www/backend/composer.json
ADD ./composer.lock /www/backend/composer.lock

WORKDIR /www/backend

RUN composer install --no-scripts --no-autoloader

# итоговый образ
FROM base-php-pfm

ADD . /www/backend

ADD --chown=www-data:www-data ./ /www/backend
COPY --from=deps-backend --chown=www-data:www-data /www/backend/vendor /www/backend/vendor

WORKDIR /www/backend

USER www-data

RUN composer dump-autoload && \
    php artisan config:clear && \
    php artisan storage:link

EXPOSE 9000
