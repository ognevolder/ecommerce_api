# Image:
FROM php:8.5-fpm-alpine

# Dependencies:
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    linux-headers

# Extensions:
RUN docker-php-ext-install pdo_mysql gd zip \
    && pecl install redis \
    && docker-php-ext-enable redis

# Composer:
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directory:
WORKDIR /var/www/html

# Files:
COPY . .

# Ports:
EXPOSE 9000

# Execute:
CMD [ "php-fpm" ]