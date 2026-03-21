
FROM php:8.2-apache
RUN if [ -f /etc/apache2/mods-enabled/mpm_event.load ]; then a2dismod mpm_event; fi && \
    a2enmod mpm_prefork rewrite headers
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html
RUN a2enmod log_config
EXPOSE 80
# Start Apache using our startup script
CMD ["./start-apache.sh"]