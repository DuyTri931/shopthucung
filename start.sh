#!/bin/bash
set -e

# Render provides $PORT. Apache must listen on it.
PORT=${PORT:-10000}

sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Laravel optimize (không fail nếu thiếu .env)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

apache2-foreground
