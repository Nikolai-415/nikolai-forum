FROM php:8.1.8-apache-bullseye

# Используемое окружение: dev, test или prod
ARG ENVIRONMENT=dev

# Обновление всех компонентов (необязательно) - только если не окружение разработки, чтобы разработка была быстрее
RUN if [ "${ENVIRONMENT}" -ne "dev" ]; then apt-get update && apt-get upgrade -y; fi

# Установка драйвера MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Для работы .htaccess
RUN a2enmod rewrite
