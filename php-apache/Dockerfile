# Образ PHP с сервером Apache
ARG PHP_VERSION
FROM php:${PHP_VERSION}-apache-bookworm

# Используемое окружение: dev, test или prod
ARG ENVIRONMENT

# Обновление всех компонентов (на окружении разработки не делаем, чтобы разработка была быстрее)
RUN if [ "${ENVIRONMENT}" != "dev" ]; then \
        apt-get update && \
        apt-get upgrade -y; \
    fi

# Копируем INI-настройки
COPY ./ini /usr/local/etc/php

# Для работы .htaccess
RUN a2enmod rewrite

# Установка драйвера MySQL (работа с БД)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Включение OPCache (кэширование, ускоряет работу)
RUN docker-php-ext-enable opcache

# Версия Xdebug
ARG XDEBUG_VERSION

# Скачивание и включение XDebug (только на окружении разработки, так как на других debug не нужен)
RUN if [ "${ENVIRONMENT}" = "dev" ]; then \
        pecl install "xdebug-${XDEBUG_VERSION}" && \
        docker-php-ext-enable xdebug; \
    else \
        rm /usr/local/etc/php/conf.d/xdebug.ini; \
    fi

WORKDIR /var/www/html

# Копируем исходные файлы
COPY ./public .
