FROM php:8.3-fpm

# Install system dependencies (minimal, hanya yang benar-benar dipakai)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    libicu-dev \
    && docker-php-ext-install \
        zip \
        pdo \
        pdo_mysql \
        intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy all files (termasuk public/build yang sudah di-build di local)
COPY . .

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Expose port
EXPOSE 8000

# Command default
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]