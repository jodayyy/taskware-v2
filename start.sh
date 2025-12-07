#!/bin/sh
set -e

echo "Starting Taskware v2 application..."

# Run migrations
php artisan migrate --force --no-interaction

# Clear all caches first to ensure fresh component registration
php artisan optimize:clear

# Verify component directories exist
echo "Verifying component directories..."
ls -la resources/views/components/ || echo "WARNING: components directory not found"

# Cache configuration (this will re-register components via AppServiceProvider)
php artisan config:cache
php artisan route:cache

# Do NOT cache views - view caching can break component discovery
# php artisan view:cache

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
echo "Application started successfully!"
exec nginx -g "daemon off;"