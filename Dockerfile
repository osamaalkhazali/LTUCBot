# PHP 8.3 for package compatibility (PhpSpreadsheet/ZipStream)
FROM php:8.3-cli

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# Install required packages + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd intl bcmath \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# 1) Install dependencies without scripts (to avoid requiring artisan)
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# 2) Now copy the rest of the project (including artisan)
COPY . .

# (Optional) Run scripts after copying everything:
# RUN composer run-script post-autoload-dump || true

# Run Laravel on the port provided by Render
EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
