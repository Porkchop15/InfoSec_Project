FROM php:8.1-apache

# Enable mod_rewrite for .htaccess support (optional)
RUN a2enmod rewrite

# Copy project files to the Apache root directory
COPY . /var/www/html/

# Expose port 80 to allow web traffic
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
