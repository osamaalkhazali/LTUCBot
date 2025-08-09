# PHP 8.3 CLI (مطلوب لحزمك الحالية)
FROM php:8.3-cli

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# حزم لازمة + امتدادات PHP
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd intl bcmath \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# استفادة من الكاش: نزّل الديبندنسيز أولًا
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# بعدها انسخ بقية المشروع
COPY . .

# شغّل على المنفذ الذي يوفره Render
EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
