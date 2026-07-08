#!/bin/sh
set -e

if [ ! -f /app/database/.env ]; then
    cp .env.example /app/database/.env
fi

ln -sf /app/database/.env /app/.env

if [ -z "$APP_KEY" ]; then
    if ! grep -q "^APP_KEY=.\+" /app/.env 2>/dev/null; then
        php artisan key:generate --force --no-interaction
    fi
fi

if [ ! -f /app/database/conduit.sqlite ]; then
    cp /app/conduit.sqlite /app/database/conduit.sqlite
fi

php artisan migrate --force --no-interaction

php artisan config:cache
php artisan route:cache
php artisan storage:link --force --no-interaction 2>/dev/null || true

exec /usr/bin/supervisord -c /etc/supervisord.conf
