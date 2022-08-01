FROM php:8.1.8-apache-bullseye

# Обновление всех компонентов (необязательно)
RUN apt-get update && apt-get upgrade -y

# Установка драйвера MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Для работы .htaccess
RUN a2enmod rewrite
