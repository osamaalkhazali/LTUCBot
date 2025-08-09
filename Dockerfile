# استخدم صورة PHP 8.2 مع CLI
FROM php:8.2-cli

# تثبيت الإضافات المطلوبة لـ Laravel + MySQL
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع
WORKDIR /var/www
COPY . .

# تثبيت مكتبات Laravel
RUN composer install --no-dev --optimize-autoloader

# فتح المنفذ وتشغيل Laravel
EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000
