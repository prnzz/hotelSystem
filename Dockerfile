FROM php:8.2-apache

# 1. Fix the MPM conflict immediately
RUN a2dismod mpm_event || true && a2enmod mpm_prefork || true

# 2. Install database extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 3. Enable Apache rewrite
RUN a2enmod rewrite

# 4. Copy your Hotel System files
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# 5. Setup the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]