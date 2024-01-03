FROM php:7.4.0-apache

#Install git and MySQL extensions for PHP

RUN echo "deb http://archive.debian.org/debian stretch main" > /etc/apt/sources.list
RUN apt-get update && apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/web
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY ../. /var/www/html/

EXPOSE 80/tcp
EXPOSE 443/tcp

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777  /var/www/html


RUN apt-get update && \
    apt-get install -y --no-install-recommends \
# Tools
    apt-utils \
    wget \
    git \
    nano \
    vim \
    iputils-ping \
    default-mysql-client \
    locales \
    imagemagick \
    graphicsmagick \
    ghostscript \
# Configure PHP
    libxml2-dev libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev libzip-dev && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install -j$(nproc) mysqli soap gd zip opcache && \
    echo 'always_populate_raw_post_data = -1\nmax_execution_time = 240\nmemory_limit = -1\nmax_input_vars = 1500\nupload_max_filesize = 200M\npost_max_size = 300M' > /usr/local/etc/php/conf.d/typo3.ini && \
# Configure bash
    echo 'export LS_OPTIONS="--color=auto"\nalias ls="ls $LS_OPTIONS"\nalias ll="ls $LS_OPTIONS -aGFlh"\nalias l="ls $LS_OPTIONS -FG"' > ~/.bashrc && \
# Configure Apache & clean
    a2enmod rewrite && \
    apt-get clean && \
    apt-get -y purge \
        libxml2-dev libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev && \
    rm -rf /var/lib/apt/lists/* /usr/src/*
# ======= composer =======
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Set locales
RUN locale-gen en_US.UTF-8 en_GB.UTF-8 de_DE.UTF-8 es_ES.UTF-8 fr_FR.UTF-8 it_IT.UTF-8 km_KH sv_SE.UTF-8 fi_FI.UTF-8

