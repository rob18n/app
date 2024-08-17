FROM php:8.2-fpm-alpine

# Install necessary PHP extensions and Nginx
RUN apk add --no-cache nginx libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Set working directory
WORKDIR /var/www/html

# Copy the existing application code
COPY . .

# Install Composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Set correct permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy custom nginx.conf
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Copy Nginx server block configuration file
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Command to run migrations and start services
CMD php artisan migrate --force && php-fpm -D && nginx -g 'daemon off;'

# Expose port 80
EXPOSE 80
