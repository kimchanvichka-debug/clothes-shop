FROM php:8.2-fpm

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev nginx

# 2. Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# 3. Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

# 5. Install Dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install && npm run build

# 6. CRITICAL PERMISSIONS FIX
# We create the subfolders manually to ensure Laravel doesn't choke
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# 7. Build Assets for Mobile/Laptop Responsiveness
RUN php artisan filament:assets
RUN php artisan optimize:clear

EXPOSE 10000

# 8. Start Command (The Fixer)
CMD php artisan storage:link && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan serve --host=0.0.0.0 --port=10000