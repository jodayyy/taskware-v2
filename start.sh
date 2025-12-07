#!/bin/sh
set -e

echo "Starting Taskware v2 application..."

# Ensure APP_KEY has base64: prefix
if [ -n "$APP_KEY" ]; then
    if [ "${APP_KEY#base64:}" = "$APP_KEY" ]; then
        echo "APP_KEY is missing 'base64:' prefix, adding it..."
        export APP_KEY="base64:$APP_KEY"
    fi
else
    echo "APP_KEY is not set, generating new key..."
    php artisan key:generate --force --no-interaction
fi

# Run migrations
php artisan migrate --force --no-interaction

# Clear all caches first to ensure fresh component registration
php artisan optimize:clear

# Verify all resources files against manifest
echo "========================================="
echo "Verifying resources files against manifest..."
echo "========================================="

MANIFEST_FILE=".resources-manifest.txt"
MISSING_FILES=""
TOTAL_FILES=0
FOUND_FILES=0

if [ ! -f "$MANIFEST_FILE" ]; then
    echo "WARNING: Manifest file not found at $MANIFEST_FILE"
    echo "Skipping resource file verification..."
else
    echo "Reading manifest from: $MANIFEST_FILE"
    
    # Read each line from manifest and verify file exists
    while IFS= read -r file_path || [ -n "$file_path" ]; do
        # Skip empty lines
        [ -z "$file_path" ] && continue
        
        TOTAL_FILES=$((TOTAL_FILES + 1))
        
        if [ -f "$file_path" ]; then
            echo "✓ Found: $file_path"
            FOUND_FILES=$((FOUND_FILES + 1))
        else
            echo "ERROR: Missing file: $file_path"
            MISSING_FILES="$MISSING_FILES $file_path"
        fi
    done < "$MANIFEST_FILE"
    
    # Summary
    echo ""
    echo "========================================="
    echo "Verification Summary"
    echo "========================================="
    echo "Total files in manifest: $TOTAL_FILES"
    echo "Files found: $FOUND_FILES"
    echo "Files missing: $((TOTAL_FILES - FOUND_FILES))"
    
    if [ -n "$MISSING_FILES" ]; then
        echo ""
        echo "========================================="
        echo "DEPLOYMENT FAILED: Missing resource files"
        echo "========================================="
        echo "Missing files:$MISSING_FILES"
        echo ""
        echo "These files were expected based on the build manifest but are missing in production."
        echo "Please check your deployment process."
        exit 1
    fi
    
    echo ""
    echo "✓ All resource files verified successfully!"
fi

# Verify component directories exist
echo "Verifying component directory structure..."
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