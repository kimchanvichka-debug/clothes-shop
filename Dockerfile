FROM php:8.2-fpm

# Install system dependencies + Node.js (Needed for CSS/JS)
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

# Install Node.js 20 (This is the missing piece for the visuals!)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Install and ENABLE PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . /var/www

# Fix for timeouts
ENV COMPOSER_PROCESS_TIMEOUT=600

# 1. Install PHP dependencies
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs

# 2. Build the CSS/JS (This makes the dashboard look right)
RUN npm install && npm run build

# Create necessary folders and Give permissions
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Start command
CMD php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan filament:assets && \
    php artisan storage:link && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=80