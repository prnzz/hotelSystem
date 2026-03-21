FROM php:8.2-apache

# 1. Install database extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 2. Fix the MPM conflict and enable rewrite in one step
RUN a2dismod mpm_event || true && \
    a2enmod mpm_prefork || true && \
    a2enmod rewrite

# 3. Copy your project files
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# 4. Use ONLY this command to start
CMD ["apache2-foreground"]