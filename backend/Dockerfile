FROM php:8.2-fpm-alpine

# Install dependencies needed for GD and other extensions
RUN apk add --no-cache \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    libwebp-dev \
    zlib-dev \
    libzip-dev \
    oniguruma-dev \
    unzip \
    git \
    curl \
    g++ \
    make \
    autoconf \
    pkgconf \
    file \
    && apk add --no-cache --virtual .build-deps \
       freetype-dev \
       libjpeg-turbo-dev \
       libpng-dev \
       libwebp-dev \
       zlib-dev

# Configure and install GD extension
RUN docker-php-ext-configure gd \
    --with-jpeg \
    --with-webp \
    --with-freetype \
    --enable-gd \
    && docker-php-ext-install -j$(nproc) gd

# Install additional common Laravel-required extensions
RUN docker-php-ext-install pdo_mysql mbstring exif zip

# Optional cleanup of build deps
RUN apk del .build-deps

# Set working directory
WORKDIR /var/www/html

# Copy Laravel app
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader

# Start Laravel dev server
CMD ["php-fpm"]
