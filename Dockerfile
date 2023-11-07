# FROM php:8.1-fpm-alpine

# # RUN docker-php-ext-install pdo pdo_mysql
# RUN docker-php-ext-install pdo pdo_pgsql

# run curl -sS https://getcomposer.org/installer | php --\
#          --install-dir=/usr/local/bin --filename=composer

# WORKDIR /app
# COPY . .
# RUN composer install

# # CMD php artisan server --host=0.0.0.0

# CMD ["php", "artisan", "serve", "--host=0.0.0.0"]




FROM php:8.2.4-fpm-alpine


# Add the following line to allow Composer to run as a superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
# Update and upgrade Alpine Linux
RUN apk update && apk upgrade

# Install the PostgreSQL extension and other dependencies
RUN apk add --no-cache postgresql-dev

# Install libsodium
RUN apk add --no-cache libsodium-dev

# Enable required PHP extensions in the configuration
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install sodium

# Explicitly enable extensions
RUN echo "extension=pdo_pgsql.so" > /usr/local/etc/php/conf.d/docker-php-ext-pdo_pgsql.ini
RUN echo "extension=sodium.so" > /usr/local/etc/php/conf.d/docker-php-ext-sodium.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

# Install Composer dependencies
RUN composer install --ignore-platform-reqs

# CMD php artisan server --host=0.0.0.0
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
