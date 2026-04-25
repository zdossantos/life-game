# ─── Stage 1: Build frontend assets ─────────────────────────────────────────
FROM node:22-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY . .
RUN npm run build

# ─── Stage 2: Production image (PHP-FPM + Nginx + Supervisor) ────────────────
FROM php:8.2-fpm-alpine

# Install system packages and PHP extensions
RUN apk add --no-cache \
        nginx \
        supervisor \
        curl \
        libpng-dev \
        libzip-dev \
        zip \
        unzip \
        git \
        sqlite-dev \
        oniguruma-dev \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        pdo_mysql \
        opcache \
        pcntl \
        zip \
        mbstring \
    && rm -rf /tmp/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --optimize-autoloader

# Copy application source
COPY . .

# Copy built frontend assets from node stage
COPY --from=node-builder /app/public/build ./public/build

# Run Composer post-install scripts and set permissions
RUN composer run-script post-autoload-dump \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy configuration files
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/site.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-app.ini

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
