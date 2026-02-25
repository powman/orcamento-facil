#!/bin/sh
set -e

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Wait for the database to be ready
echo "Waiting for database connection..."
until php -r "new PDO('mysql:host=${DB_HOST:-mariadb};port=${DB_PORT:-3306};dbname=${DB_DATABASE:-orcamentos_db}', '${DB_USERNAME:-laravel}', '${DB_PASSWORD:-secret}');" > /dev/null 2>&1; do
    echo "Database not ready yet, retrying in 2 seconds..."
    sleep 2
done
echo "Database is ready."

# Run migrations
php artisan migrate --force

# Cache config and routes in production
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Start Laravel
exec php artisan serve --host=0.0.0.0 --port=8000
