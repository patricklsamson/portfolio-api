#!/usr/bin/env bash
echo "Running composer first cycle"
composer clear-cache
composer install
composer dump-autoload
composer update

echo "Running composer second cycle"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html
composer dump-autoload
composer update

echo "Clearing cache..."
php artisan cache:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
