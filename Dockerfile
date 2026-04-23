FROM php:8.4-apache

# Устанавливаем PostgreSQL драйвер
RUN docker-php-ext-install pdo_pgsql

# Включаем Apache mod_rewrite (если нужно)
RUN a2enmod rewrite

# Копируем все файлы проекта в веб-директорию
COPY . /var/www/html/

# Даем права на запись (если нужно для сессий/загрузки)
RUN chown -R www-data:www-data /var/www/html