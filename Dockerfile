FROM php:8.4-cli

# Installation des dépendances et des extensions PHP requises (XML, DOM, SQLite)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libxml2-dev \
    libsqlite3-dev \
    && docker-php-ext-install xml dom pdo pdo_sqlite

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Lance le serveur interne de Symfony sur le port 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
