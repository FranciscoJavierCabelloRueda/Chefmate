# Usa la imagen oficial de PHP 8.3 con Apache
FROM php:8.3-apache

# Instala dependencias del sistema necesarias para Laravel y Composer
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git              

# Habilita el módulo mod_rewrite de Apache, necesario para las rutas amigables de Laravel
RUN a2enmod rewrite

# Instala extensiones de PHP requeridas por Laravel
RUN docker-php-ext-install pdo_mysql zip

# Define la raíz pública de Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
  && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copia el proyecto al contenedor
COPY . /var/www/html
WORKDIR /var/www/html

# Instala Composer y dependencias de Laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && composer install --no-interaction --prefer-dist --optimize-autoloader

# Instala node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -  \
  && apt-get install -y nodejs \
  && npm install -g npm@latest

# Ajusta permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Expone el puerto
EXPOSE 80