FROM php:5.6-apache
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
	unzip \
    && docker-php-ext-install -j$(nproc) iconv mcrypt zip mysqli pdo

COPY composer.phar /var/www/html
COPY composer.json /var/www/html
RUN cd /var/www/html && php composer.phar install --no-dev
COPY src/ /var/www/html/src

EXPOSE 80