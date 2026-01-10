#!/bin/bash
set -e

PORT=${PORT:-10000}

# Apache listen on Render PORT
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Laravel: clear cache (an toàn)
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# ✅ Auto migrate (bắt buộc khi DB mới)
php artisan migrate --force || true

# Nếu bạn có seed dữ liệu (tuỳ chọn)
# php artisan db:seed --force || true

apache2-foreground
