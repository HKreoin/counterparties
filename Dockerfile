FROM php:8.3-fpm

# Копируем файлы зависимостей
COPY composer.lock composer.json /var/www/
# Установка рабочего каталога
WORKDIR /var/www
# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Установка расширений PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копирование кода приложения
COPY . /var/www
# Установка прав
RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache
# Установка зависимостей
RUN composer install && npm install

EXPOSE 9000
CMD ["php-fpm"]
