#!/bin/sh
set -e

if [ "${1#-}" != "$1" ] || [ -z "$(command -v "$1")" ]; then
  set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ]; then
  echo "[entrypoint] Ожидание MySQL…"
  i=0
  while [ "$i" -lt 60 ]; do
    if php artisan db:show >/dev/null 2>&1; then
      break
    fi
    i=$((i + 1))
    sleep 2
  done

  if [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "[entrypoint] vendor пуст — composer install…"
    composer install --no-dev --no-interaction --prefer-dist
    chown -R www-data:www-data /var/www/html/vendor 2>/dev/null || true
  fi

  php artisan migrate --force
  php artisan storage:link 2>/dev/null || true

  if [ -d /var/www/html/storage ] && [ -w /var/www/html/storage ]; then
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
    chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
  fi

  if [ "${APP_ENV:-local}" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
  fi
fi

exec "$@"
