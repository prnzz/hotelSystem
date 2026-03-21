FROM php:8.2-apache

# Install necessary extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable the rewrite module
RUN a2enmod rewrite

# Copy your project files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# The standard command to start Apache in this container
CMD ["apache2-foreground"]