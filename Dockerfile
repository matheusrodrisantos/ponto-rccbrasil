FROM php:8.4.5-fpm

ARG APP_UID=1000
ARG APP_USER=appuser

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

RUN echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

RUN echo "root:123456" | chpasswd

RUN useradd -m -u ${APP_UID} -s /bin/bash ${APP_USER}

RUN mkdir -p /var/www/html/var /var/www/html/vendor && \
    chown -R www-data:www-data /var/www/html/var /var/www/html/vendor

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chown -R ${APP_USER}:${APP_USER} /var/www/html

EXPOSE 9000

USER appuser
