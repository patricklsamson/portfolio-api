#!/usr/bin/env bash
echo "Running composer first cycle"
composer clear-cache
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader
cp .env.example .env

echo "Running composer second cycle"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader
composer dump-autoload

echo "Clearing cache..."
php artisan cache:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
