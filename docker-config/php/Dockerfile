FROM php:8.1-fpm
WORKDIR /var/www
ADD . /var/www

# permission
RUN chown -R www-data:www-data /var/www

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

# install packages
RUN apt-get update \
  && apt-get install -y \
  gcc \
  make \
  git \
  unzip \
  vim \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libmcrypt-dev \
  libpq-dev \
  curl \
  gnupg \
  openssl \
  nodejs \
  && docker-php-ext-install pdo_mysql mysqli \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd

# Add php.ini
COPY php.ini /usr/local/etc/php/

# # install stable node and latest npm
# RUN curl -sL https://deb.nodesource.com/setup_18.x | bash
# RUN apt-get update \
#   && apt-get install -y nodejs 
# # install node packages
# RUN npm install -g n
# RUN n stable
# RUN npm update -g npm

# mailhog設定
# RUN curl -sSLO https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 \
# && chmod +x mhsendmail_linux_amd64 \
# && mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail \
# && echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' > /usr/local/etc/php/conf.d/sendmail.ini

# RUN apt-get update
# RUN apt-get install -y vim
# RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail
# RUN chmod +x mhsendmail
# RUN mv mhsendmail /usr/local/bin/mhsendmail
# COPY ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update; apt-get install -y ssmtp
COPY ./php.ini /usr/local/etc/php/php.ini