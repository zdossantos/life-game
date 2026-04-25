#!/bin/sh
set -e

cd /var/www/html

# Install PHP dependencies when vendor is missing (first run or fresh volume)
if [ ! -f vendor/autoload.php ]; then
    echo "→ Installing PHP dependencies…"
    composer install --no-interaction --prefer-dist
fi

# Bootstrap .env from the example when not present
if [ ! -f .env ]; then
    echo "→ Creating .env from .env.example…"
    cp .env.example .env
    php artisan key:generate
fi

# Create the SQLite database and run migrations when not yet initialised
if [ ! -f database/database.sqlite ]; then
    echo "→ Creating SQLite database and running migrations…"
    touch database/database.sqlite
    php artisan migrate --force
fi

exec "$@"
