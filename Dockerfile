# Use the official PHP 7.4 FPM Alpine Linux image
FROM php:7.4-fpm-alpine

# Set the working directory
WORKDIR /var/www/html

# Copy the files to the container
COPY . /var/www/html

# Install required packages
RUN apk update && apk add --no-cache \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    nginx \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# Copy the nginx configuration file to the container
COPY ./nginx.conf /etc/nginx/conf.d/

# Copy the supervisor configuration file to the container
COPY ./supervisor.conf /etc/supervisor/conf.d/

# Expose port 80
EXPOSE 80

# Start supervisord
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
