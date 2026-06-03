FROM php:8.4-cli

RUN apt-get update \
  && apt-get install -y git unzip libzip-dev zlib1g-dev libpng-dev libonig-dev libxml2-dev curl \
  && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN useradd -ms /bin/bash dev || true
USER dev
