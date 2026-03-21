# Use an official PHP image with Apache
FROM php:8.2-apache

# Install the MySQL extension for PHP
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your project files into the container
COPY . /var/www/html/

# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html/

# Use the port Render expects
EXPOSE 80