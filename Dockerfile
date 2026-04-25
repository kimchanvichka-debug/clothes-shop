FROM php:8.2-fpm

# Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nginx

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Install and ENABLE PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

ENV COMPOSER_PROCESS_TIMEOUT=600

# 1. Install dependencies
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install && npm run build

# 2. THE FIX: Permissions (This stops the 500 Error)
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# 3. Optimize for Production
RUN php artisan optimize
RUN php artisan filament:assets

# We use port 10000 because Render loves it
EXPOSE 10000

# 4. Start command (Forcing port 10000)
CMD php artisan storage:link && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000