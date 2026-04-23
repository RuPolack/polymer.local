FROM php:8.4-apache

# Устанавливаем системные библиотеки и драйвер
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Включаем Apache mod_rewrite
RUN a2enmod rewrite

# Копируем проект
COPY . /var/www/html/

# Даем права
RUN chown -R www-data:www-data /var/www/html