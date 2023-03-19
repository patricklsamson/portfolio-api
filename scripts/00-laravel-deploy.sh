#!/usr/bin/env bash
composer install --no-dev --optimize-autoloader
composer dump-autoload
chmod -R 775 storage
cp .env.example .env
php artisan cache:clear
php -r "file_exists('.env') || copy('.env.example', '.env');"

echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
