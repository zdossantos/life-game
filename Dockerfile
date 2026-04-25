# ─── Stage 1: Build frontend assets ────────────────────────────────────────────
FROM node:20-alpine AS frontend

WORKDIR /app

RUN npm install -g pnpm

COPY package.json pnpm-lock.yaml ./
RUN pnpm install --frozen-lockfile

COPY . .
RUN pnpm run build

# ─── Stage 2: Install PHP dependencies ─────────────────────────────────────────
FROM composer:2.8 AS composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev

# ─── Stage 3: Production runtime ───────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS production

# System deps + PHP extensions
RUN apk add --no-cache \
        nginx \
        supervisor \
        sqlite \
        sqlite-dev \
        libzip-dev \
        oniguruma-dev \
        libxml2-dev \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        mbstring \
        zip \
        xml \
        dom \
        tokenizer \
        bcmath \
        fileinfo \
        opcache

# PHP production config
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/app.ini

# Nginx config
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Supervisord config
COPY docker/supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/html

# Application files (source first so the next COPY layers can override)
COPY --chown=www-data:www-data . .

# PHP vendor from the composer stage
COPY --from=composer --chown=www-data:www-data /app/vendor ./vendor

# Built frontend assets from the node stage
COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build

# Writable directories — permissions are finalised at runtime by the entrypoint
RUN chmod -R 775 storage bootstrap/cache

# Production entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
