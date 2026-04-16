#!/bin/sh
set -e

# Composer/post-install scripts вызывают git; в bind-mount с другим владельцем иначе «dubious ownership».
git config --global --add safe.directory /var/www/html 2>/dev/null || true

if [ "${1#-}" != "$1" ] || [ -z "$(command -v "$1")" ]; then
  set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ]; then
  # С bind-mount с хоста в cache лежит package discovery от `composer install` с dev;
  # в контейнере vendor без dev — любой `php artisan` падает, пока не снести кэш.
  echo "[entrypoint] Сброс bootstrap/cache/packages.php и services.php (если есть)…"
  rm -f /var/www/html/bootstrap/cache/packages.php /var/www/html/bootstrap/cache/services.php

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

  # app/ с хоста (bind-mount), vendor в named volume — classmap из образа не видит новые модели.
  echo "[entrypoint] composer dump-autoload (синхронизация App\\ с текущим app/)…"
  composer dump-autoload --optimize --no-interaction --no-ansi --no-scripts
  chown -R www-data:www-data /var/www/html/vendor 2>/dev/null || true

  echo "[entrypoint] package:discover…"
  php artisan package:discover --ansi --no-interaction

  php artisan migrate --force
  php artisan storage:link 2>/dev/null || true

  if [ -d /var/www/html/storage ] && [ -w /var/www/html/storage ]; then
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
    chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
  fi

  if [ "${APP_ENV:-local}" = "production" ]; then
    php artisan config:cache
    # bind-mount routes/web.php обновляется чаще образа — без clear остаётся старый route:cache → 500 «Route not defined»
    php artisan route:clear 2>/dev/null || true
    php artisan route:cache
    php artisan view:cache
  fi
fi

exec "$@"
