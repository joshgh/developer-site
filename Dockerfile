FROM php:7.0-apache

RUN apt-get update && apt-get install -y git-core unzip emacs-nox

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

ADD vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
RUN a2ensite 000-default.conf

COPY . /var/www/html

RUN composer install --no-scripts
RUN rm -Rf var/cache/dev/*

RUN usermod -u 1000 www-data

EXPOSE 8000
EXPOSE 80