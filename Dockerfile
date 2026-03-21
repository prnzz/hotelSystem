FROM php:8.2-apache

# 1. Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 2. Fix Apache MPM conflict (Do this BEFORE copying files)
RUN a2dismod mpm_event || true && a2enmod mpm_prefork || true
RUN a2enmod rewrite

# 3. Copy files and set permissions
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# 4. Setup Entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]