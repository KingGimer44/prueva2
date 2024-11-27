FROM php:8.2-apache
COPY . /var/www/html/

RUN chmod -R 755 /var/www/html/

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

CMD ["apache2-foreground"]
