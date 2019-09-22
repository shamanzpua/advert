FROM php:7.1-fpm

RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath

RUN pecl install mongodb \
  && docker-php-ext-enable mongodb

RUN  apt-get update && apt-get install -y git zlib1g-dev \
    && apt-get install -y libimage-exiftool-perl \
    && apt-get install -y mat \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:1.6.5 /usr/bin/composer /usr/bin/composer

#xhprof
RUN git clone https://github.com/tideways/php-profiler-extension.git /tmp/php-profiler-extension \
    && docker-php-ext-configure /tmp/php-profiler-extension \
    && docker-php-ext-install /tmp/php-profiler-extension \
    && rm -r /tmp/php-profiler-extension

#ARG USERID=1000
#RUN usermod -u $USERID www-data

RUN mkdir /var/www/.composer && chown -R www-data /var/www/.composer
ENV COMPOSER_HOME /var/www/.composer

#USER www-data

WORKDIR /var/www/board

RUN cd /var/www/board && composer install
