FROM php:8.4-apache

# -----------------------------
# System Dependencies & PHP Extensions
# -----------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    zip \
    nodejs \
    npm \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        zip \
        mbstring \
        xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------
# Apache Configuration
# -----------------------------
RUN a2enmod rewrite

# Change Apache port to 10000 (Render requirement)
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

# Set Laravel public as document root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Enable .htaccess for Laravel
RUN printf '<Directory /var/www/html/public>\n\
AllowOverride All\n\
Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# -----------------------------
# Install Composer
# -----------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -----------------------------
# Application Setup
# -----------------------------
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install frontend dependencies & build
RUN npm install && npm run build

# Laravel cache cleanup
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Storage link (safe fallback)
RUN php artisan storage:link || true

# -----------------------------
# Permissions
# -----------------------------
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    public/uploads \
    && chown -R www-data:www-data storage bootstrap/cache public/uploads \
    && chmod -R 775 storage bootstrap/cache public/uploads

# -----------------------------
# (Optional) Database Migration
# ⚠ Not recommended during build (better at runtime)
# -----------------------------
# RUN php artisan migrate --force || true

# -----------------------------
# Expose Port
# -----------------------------
EXPOSE 10000

# -----------------------------
# Start Server
# -----------------------------
CMD ["apache2-foreground"]