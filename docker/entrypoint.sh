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

php artisan migrate --force --no-interaction

if [ ! -f /app/database/.seed_done ]; then
    php artisan db:seed --force --no-interaction
    touch /app/database/.seed_done
fi

php artisan config:cache
php artisan route:cache
php artisan storage:link --force --no-interaction 2>/dev/null || true

exec /usr/bin/supervisord -c /etc/supervisord.conf
