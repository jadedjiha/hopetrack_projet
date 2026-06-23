# =============================================================================
# HopeTrack — Dockerfile Laravel + Frontend (MySQL)
# =============================================================================
FROM php:8.4-cli

# -----------------------------------------------------------------------------
# 1. Dépendances système — MySQL uniquement (PostgreSQL supprimé)
# -----------------------------------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    # nc pour le health-check MySQL dans entrypoint.sh
    netcat-openbsd \
    # Libs PHP nécessaires
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------------------------------------------------------
# 2. Extensions PHP — MySQL uniquement, GD correctement configuré
# -----------------------------------------------------------------------------
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        gd \
        exif \
        zip \
        bcmath \
        mbstring \
        opcache \
        intl

# -----------------------------------------------------------------------------
# 3. Node.js 20 LTS — pour compiler les assets Vite (frontend)
# -----------------------------------------------------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------------------------------------------------------
# 4. Composer
# -----------------------------------------------------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# -----------------------------------------------------------------------------
# 5. PHP deps — copiés AVANT le code source pour profiter du cache Docker
#    → rebuild Composer uniquement si composer.json ou composer.lock change
# -----------------------------------------------------------------------------
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-dev --no-scripts

# -----------------------------------------------------------------------------
# 6. Node deps — même logique de cache
# -----------------------------------------------------------------------------
COPY package.json package-lock.json* ./
RUN npm ci

# -----------------------------------------------------------------------------
# 7. Copie du projet complet
# -----------------------------------------------------------------------------
COPY . .

# -----------------------------------------------------------------------------
# 8. Post-install Composer (déclenche package:discover, etc.)
# -----------------------------------------------------------------------------
RUN composer run-script post-autoload-dump --no-interaction

# -----------------------------------------------------------------------------
# 9. Compilation des assets frontend (Vite → public/build/)
# -----------------------------------------------------------------------------
RUN npm run build && rm -rf node_modules

# -----------------------------------------------------------------------------
# 10. Permissions
# -----------------------------------------------------------------------------
RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/app/public \
        bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# -----------------------------------------------------------------------------
# 11. Nettoyage des caches au build (sans accès DB — ne pas cacher ici)
# -----------------------------------------------------------------------------
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

EXPOSE 8000

ENTRYPOINT ["/bin/bash", "/app/entrypoint.sh"]