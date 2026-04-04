#!/usr/bin/env bash
# Деплой на VPS: вызывается по SSH из GitHub Actions (или вручную).
set -euo pipefail
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT"

git fetch origin main
git reset --hard origin/main

docker compose build app

# Именованный том перекрывает public/build из образа — без удаления тома CSS/JS остаются старыми.
docker compose down
VOL="$(docker volume ls -q --filter name=prostoy_public_build | head -1 || true)"
if [[ -n "${VOL}" ]]; then
  docker volume rm "${VOL}"
fi

docker compose up -d

# Дождаться готовности app (healthcheck в compose)
for _ in $(seq 1 40); do
  if docker compose exec -T app php artisan migrate:status >/dev/null 2>&1; then
    break
  fi
  sleep 3
done

docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan view:cache

echo "Deploy OK: $(git rev-parse --short HEAD)"
