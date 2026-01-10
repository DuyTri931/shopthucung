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

# ✅ Tạo key nếu lỡ thiếu (không bắt buộc nhưng giúp tránh crash)
if [ -z "$APP_KEY" ]; then
  echo "APP_KEY is missing. Skipping key generation (set APP_KEY in Render env)."
fi

# ✅ Migrate: chạy an toàn, nếu fail sẽ in lỗi nhưng KHÔNG làm app chết
echo "Running migrations..."
php artisan migrate --force || (echo "Migrate failed - check logs for migration order/FK issues" && true)

# ✅ Cache lại cho production (tuỳ chọn, nếu bạn muốn)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start Apache
apache2-foreground
