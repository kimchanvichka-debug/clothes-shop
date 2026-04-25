FROM php:8.2-fpm

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev nginx libicu-dev

# 2. Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# 3. Install PHP extensions
RUN docker-php-ext-configure intl && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# 4. Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

# 5. Install Dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install && npm run build

# 6. THE "ULTIMATE" PERMISSIONS FIX
# We create EVERY folder Filament/Livewire needs for uploads
RUN mkdir -p storage/app/public \
    storage/app/livewire-tmp \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    bootstrap/cache

# Set permissions so the 'www-data' user (which runs PHP) can actually write files
RUN chmod -R 777 storage bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 10000

# 7. Start Command
CMD php artisan storage:link && \
    php artisan migrate --force && \
    php artisan filament:assets && \
    php artisan optimize:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan serve --host=0.0.0.0 --port=10000