FROM node:22-alpine AS assets

WORKDIR /build

COPY package*.json .npmrc* ./
RUN npm ci
COPY vite.config.js ./
COPY resources ./resources
RUN npm run build


FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx supervisor sqlite-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .
COPY --from=assets /build/public/build ./public/build

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh \
    && mkdir -p /run/nginx \
    && chown -R www-data:www-data storage bootstrap/cache database

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
