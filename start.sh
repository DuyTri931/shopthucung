#!/bin/bash
set -e

PORT=${PORT:-10000}

# Apache listen on Render PORT
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Clear cached config (tránh dính DB_CONNECTION cũ)
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# ✅ Auto migrate (DB mới trên Render sẽ thiếu bảng)
php artisan migrate --force || true

apache2-foreground
