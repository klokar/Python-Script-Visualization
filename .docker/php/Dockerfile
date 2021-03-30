FROM php:7.3-fpm
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    git \
    libpng-dev \
    python3-venv \
    python3-pip \
    libxrender1 \
    libfontconfig1 \
    libx11-dev \
    libjpeg62 \
    libxtst6 \
    libzip-dev \
&& docker-php-ext-install -j$(nproc) iconv \
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&& docker-php-ext-install -j$(nproc) gd \
&& docker-php-ext-configure pdo_mysql \
&& docker-php-ext-install pdo_mysql \
&& docker-php-ext-install zip \
&& pecl install redis-4.3.0 \
&& docker-php-ext-enable redis \
&& php -r "readfile('https://getcomposer.org/installer');" | php \
&& mv composer.phar /usr/bin/composer \
&& chmod +x /usr/bin/composer;

# Pip 18.1 provided python3-pip, > 19.0 required for tensorflow
RUN python3 -m pip install --upgrade pip

# Add composer bin directory to PATH
ENV PATH /root/.composer/vendor/bin:$PATH

RUN composer global require bamarni/symfony-console-autocomplete && \
    rm -rf $HOME\.composer

WORKDIR /var/www/app
