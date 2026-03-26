FROM php:8.4-apache

# Outils système requis par Composer
RUN apt-get update && apt-get install -y unzip git && rm -rf /var/lib/apt/lists/*

# Extensions PHP nécessaires pour MySQL (PDO)
RUN docker-php-ext-install pdo pdo_mysql

# Activer mod_rewrite Apache (nécessaire pour le routeur)
RUN a2enmod rewrite

# Installer Composer (gestionnaire de dépendances PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Dossier de travail dans le container
WORKDIR /var/www/html

# Copier d'abord les fichiers Composer pour profiter du cache Docker
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction

# Copier tout le code source
COPY . .

# Configurer Apache : servir depuis /public au lieu de /
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
