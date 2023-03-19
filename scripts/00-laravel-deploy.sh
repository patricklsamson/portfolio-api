#!/usr/bin/env bash
echo "Running composer"
php artisan cache:clear
composer clear-cache
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html
composer update
composer dump-autoload

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
