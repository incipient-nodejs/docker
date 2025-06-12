#!/bin/sh
set -e

# Wait for DB if needed
if [ -n "$DB_HOST" ]; then
# Laravel setup
php artisan config:cache
php artisan config:clear
php artisan storage:link
php artisan migrate --force --no-interaction
fi


# Start actual CMD
exec "$@"
