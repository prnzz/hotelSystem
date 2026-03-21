FROM php:8.2-apache

# 1. Fix MPM conflict and install extensions
RUN a2dismod mpm_event || true && \
    a2enmod mpm_prefork || true && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite

# 2. Copy files and set permissions
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# 3. DO NOT use ENTRYPOINT. Use only this CMD:
CMD ["apache2-foreground"]