FROM php:7.4-apache

# Instalar la extensión mysqli para MySQL
RUN docker-php-ext-install mysqli

# Copiar el contenido al servidor Apache
COPY . /var/www/html/

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html
RUN mkdir -p /var/www/html/img && chown -R www-data:www-data /var/www/html/img
