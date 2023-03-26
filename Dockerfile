FROM php:8.0-fpm

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy application files
COPY . /app

# Expose port 8080 and start php-fpm server
EXPOSE 8080
CMD ["php-fpm", "--nodaemonize"]
