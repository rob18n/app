# Use an official PHP image with FPM and PHP 8.2 as the base
FROM php:8.2-fpm

# Set the working directory
WORKDIR /var/www/html

# Install system dependencies and Node.js
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the existing Laravel application
COPY . .

# Set file ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Generate the Laravel application key
RUN php artisan key:generate

# Run database migrations (optional, depends on your setup)
# RUN php artisan migrate --force

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM and Laravel server
CMD ["php-fpm"]
