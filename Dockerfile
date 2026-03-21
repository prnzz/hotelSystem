FROM php:8.2-apache

# 1. Force-fix MPM conflict and install extensions in one step
RUN a2dismod mpm_event || true && \
    a2enmod mpm_prefork || true && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite

# 2. Copy files and set permissions
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# 3. Setup Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]