FROM php:8.4-fpm
WORKDIR "/application"

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        libzip-dev \
        libonig-dev \
        redis-server \
        && pecl install redis \
        && docker-php-ext-enable redis \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql ftp zip exif \
    && echo "alias composer='php /application/composer.phar'" >> ~/.bashrc \
    && echo "alias art='php artisan'" >> ~/.bashrc
