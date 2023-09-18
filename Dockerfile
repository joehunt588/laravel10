FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

run curl -sS https://getcomposer.org/installer | php --\
         --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . . 
RUN composer install 

# CMD php artisan server --host=0.0.0.0

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]