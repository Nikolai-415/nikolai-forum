# Образ PHP с сервером Apache
ARG PHP_VERSION="8.1.8"
FROM php:${PHP_VERSION}-apache-bullseye

# Используемое окружение: dev, test или prod
ARG ENVIRONMENT="dev"
# Версия Xdebug
ARG XDEBUG_VERSION="3.1.5"

# Обновление всех компонентов (только не на окружении разработки, чтобы разработка была быстрее)
RUN if [ "${ENVIRONMENT}" != "dev" ]; then \
        apt-get update && \
        apt-get upgrade -y; \
    fi

# Копируем INI-настройки
COPY ./ini /usr/local/etc/php

# Копируем исходные файлы
COPY ./public /var/www/html

# Для работы .htaccess
RUN a2enmod rewrite

# Установка драйвера MySQL (работа с БД)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Включение OPCache (кэширование, ускоряет работу)
RUN docker-php-ext-enable opcache

# Скачивание и включение XDebug (только на окружении разработки, так как на других debug не нужен)
RUN if [ "${ENVIRONMENT}" = "dev" ]; then \
        pecl install "xdebug-${XDEBUG_VERSION}" && \
        docker-php-ext-enable xdebug; \
    else \
        rm /usr/local/etc/php/conf.d/xdebug.ini; \
    fi
