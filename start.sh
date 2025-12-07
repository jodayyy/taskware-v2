#!/bin/sh
set -e

# Ensure APP_KEY has base64: prefix
if [ -n "$APP_KEY" ]; then
    if [ "${APP_KEY#base64:}" = "$APP_KEY" ]; then
        export APP_KEY="base64:$APP_KEY"
    fi
else
    php artisan key:generate --force --no-interaction
fi

# Run migrations
php artisan migrate --force --no-interaction

# Clear all caches first to ensure fresh component registration
php artisan optimize:clear

# Copy manifest.json from .vite subdirectory if it exists there but not in root
if [ -f "public/build/.vite/manifest.json" ] && [ ! -f "public/build/manifest.json" ]; then
    cp public/build/.vite/manifest.json public/build/manifest.json
fi

# Verify manifest exists
if [ ! -f "public/build/manifest.json" ] && [ ! -f "public/build/.vite/manifest.json" ]; then
    echo "ERROR: Vite manifest.json not found" >&2
    exit 1
fi

if [ ! -d "public/build/assets" ]; then
    echo "ERROR: Vite assets directory not found" >&2
    exit 1
fi

# Verify all resources files against manifest
MANIFEST_FILE=".resources-manifest.txt"
MISSING_FILES=""

if [ -f "$MANIFEST_FILE" ]; then
    while IFS= read -r file_path || [ -n "$file_path" ]; do
        [ -z "$file_path" ] && continue
        
        if [ ! -f "$file_path" ]; then
            MISSING_FILES="$MISSING_FILES $file_path"
        fi
    done < "$MANIFEST_FILE"
    
    if [ -n "$MISSING_FILES" ]; then
        echo "ERROR: Missing resource files:$MISSING_FILES" >&2
        exit 1
    fi
fi

# Cache configuration (this will re-register components via AppServiceProvider)
php artisan config:cache
php artisan route:cache

# Do NOT cache views - view caching can break component discovery
# php artisan view:cache

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
exec nginx -g "daemon off;"