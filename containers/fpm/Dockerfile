FROM php:5.6-fpm
WORKDIR /var/www
RUN apt-get update && apt-get install -y libmcrypt-dev  && \
        apt-get install -y libpq-dev
RUN apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev
RUN echo postfix postfix/mailname string ixustrade.nl | debconf-set-selections
RUN echo postfix postfix/main_mailer_type string 'Local only' | debconf-set-selections
RUN apt-get update && apt-get install -y postfix
RUN apt-get update && apt-get install -y libxml2-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install -j$(nproc) mcrypt
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install exif
RUN docker-php-ext-install opcache
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install soap
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pgsql pdo_pgsql
RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap


RUN apt-get update &&apt-get install -y wget gnupg

RUN curl -sL https://deb.nodesource.com/setup_8.x |  bash -
RUN apt-get install -y nodejs git zip unzip
RUN npm install bower -g

RUN apt-get update &&apt-get install -y sendmail-bin sendmail
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN rm -rf /var/lib/apt/lists/*
COPY conf/php.ini /usr/local/etc/php/php.ini
COPY conf/www.conf /usr/local/etc/php-fpm.d/www.conf
