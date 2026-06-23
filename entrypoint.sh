#!/bin/bash
set -e

# =============================================================================
# HopeTrack — Entrypoint Laravel (MySQL)
# =============================================================================

# -----------------------------------------------------------------------------
# 1. Attente de MySQL — nc (netcat) remplace pg_isready (PostgreSQL)
# -----------------------------------------------------------------------------
echo "===> Attente de MySQL sur ${DB_HOST}:${DB_PORT:-3306}..."

MAX_ATTEMPTS=30
attempt=0
until nc -z "${DB_HOST}" "${DB_PORT:-3306}"; do
    attempt=$((attempt + 1))
    if [ "$attempt" -ge "$MAX_ATTEMPTS" ]; then
        echo "ERREUR : MySQL non disponible après ${MAX_ATTEMPTS} tentatives. Abandon."
        exit 1
    fi
    echo "    [${attempt}/${MAX_ATTEMPTS}] MySQL pas encore prêt, retry dans 2s..."
    sleep 2
done
echo "===> MySQL prêt !"

# -----------------------------------------------------------------------------
# 2. Migrations — JAMAIS migrate:fresh en production
#    migrate:fresh = DROP toutes les tables → perte totale des données
#    migrate       = applique uniquement les nouvelles migrations
# -----------------------------------------------------------------------------
echo "===> Migration..."
php artisan migrate --force

# -----------------------------------------------------------------------------
# 3. Seeding — DÉSACTIVÉ en production
#    db:seed à chaque restart = doublons / corruption des données
#    Pour seeder une seule fois : lancer manuellement
#      railway run php artisan db:seed --force
# -----------------------------------------------------------------------------
# php artisan db:seed --force   ← NE PAS ACTIVER EN PRODUCTION

# -----------------------------------------------------------------------------
# 4. Lien symbolique storage → public/storage (uploads, photos de profil, etc.)
# -----------------------------------------------------------------------------
echo "===> Storage link..."
php artisan storage:link --quiet || true

# -----------------------------------------------------------------------------
# 5. Mise en cache (après migration, la DB est prête)
# -----------------------------------------------------------------------------
echo "===> Cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# -----------------------------------------------------------------------------
# 6. Démarrage du serveur
#    Note : php -S est suffisant pour Railway/MVP.
#    Pour une prod haute charge → migrer vers Nginx + PHP-FPM.
# -----------------------------------------------------------------------------
echo "===> Démarrage sur port ${PORT:-8000}..."
exec php -S 0.0.0.0:"${PORT:-8000}" -t public