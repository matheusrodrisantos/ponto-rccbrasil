FROM php:8.4.5-fpm

ARG APP_UID=1000
ARG APP_USER=appuser

# Instalar pacotes
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libicu-dev \
    libxml2-dev \
    zlib1g-dev \
    libzip-dev \
    iputils-ping \
    tzdata \
    passwd \
    && ln -snf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime \
    && echo "America/Sao_Paulo" > /etc/timezone \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        intl \
        xml \
        zip \
        opcache

# Set timezone in PHP
RUN echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

# Definir senha para root (debug)
RUN echo "root:123456" | chpasswd

# Criar usuário app com UID do host (passado como build-arg)
RUN useradd -m -u ${APP_UID} -s /bin/bash ${APP_USER}

# Permitir que www-data acesse var e vendor
RUN mkdir -p /var/www/html/var /var/www/html/vendor && \
    chown -R www-data:www-data /var/www/html/var /var/www/html/vendor


# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www/html

# Copiar projeto
COPY . .

# Rodar composer install como root ou appuser depois
RUN chown -R ${APP_USER}:${APP_USER} /var/www/html

# Porta
EXPOSE 9000

# O container vai subir com root por padrão
USER appuser
