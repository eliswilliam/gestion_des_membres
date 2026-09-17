#!/bin/sh
set -e

cd /var/www/html

# Disable conflicting Apache MPM modules to prevent "More than one MPM loaded" crash
a2dismod mpm_event mpm_worker || true
a2enmod mpm_prefork || true


php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    if [ "${FRESH_MIGRATIONS:-false}" = "true" ]; then
        php artisan migrate:fresh --force --seed
    else
        php artisan migrate --force
    fi
fi

php artisan storage:link || true

exec "$@"
