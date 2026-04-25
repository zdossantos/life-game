#!/bin/sh
set -e

cd /var/www/html

# Ensure the database directory exists and is writable before any artisan call
mkdir -p database storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache database

# Create the SQLite database file if it does not exist
touch database/database.sqlite

# Run pending migrations
php artisan migrate --force

# Create the public/storage symlink if missing
php artisan storage:link --force 2>/dev/null || true

# Cache config/routes/views for production
php artisan optimize

# Hand off to supervisord (manages php-fpm + nginx)
exec supervisord -c /etc/supervisord.conf
