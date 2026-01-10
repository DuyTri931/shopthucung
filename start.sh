#!/bin/bash
set -e

PORT=${PORT:-10000}

# Apache listen on Render PORT
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Laravel: clear caches (tránh dính config cũ trên môi trường deploy)
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Check APP_KEY
if [ -z "$APP_KEY" ]; then
  echo "❌ APP_KEY is missing. Please set APP_KEY in Render env."
  exit 1
fi

# Run migrations (bắt buộc phải chạy OK)
echo "✅ Running migrations..."
php artisan migrate --force

# Optional seed (bật bằng env RUN_SEED=true)
if [ "$RUN_SEED" = "true" ]; then
  echo "✅ Seeding database..."
  php artisan db:seed --force
fi

# Cache lại cho production (tuỳ chọn)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start Apache
apache2-foreground
