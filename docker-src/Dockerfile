FROM php:7.0.22-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update && apt-get install -y git zip libpng-dev libmcrypt-dev mysql-client

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
  docker-php-ext-install gd mcrypt pdo_mysql && \
  echo '' | pecl install redis && docker-php-ext-enable redis

RUN a2enmod rewrite

COPY ./install.sh /install.sh
RUN chmod +x /install.sh

# ENTRYPOINT []
# CMD ['/install.sh']
