# Dockerfile
FROM php:8.3.6-fpm

# Install dependencies and utilities
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libssl-dev \
    unzip \
    && docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Set working directory
WORKDIR /var/www/html

# Copy the rest of the application code
COPY . ./

