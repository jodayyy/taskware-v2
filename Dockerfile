FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    nodejs \
    npm \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev \
    sqlite \
    sqlite-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Remove any existing build artifacts to ensure fresh build
RUN rm -rf public/build public/hot

# Install dependencies
# Try install first, if lock file is out of sync, update it
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist || \
    (composer update --no-dev --optimize-autoloader --no-interaction --prefer-dist && \
     composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist)

# Install npm dependencies (including dev dependencies needed for build)
RUN npm ci

# Build frontend assets
RUN npm run build

# Copy manifest.json from .vite subdirectory to root of build directory (Laravel expects it there)
# Vite 7 places manifest in .vite subdirectory, but Laravel expects it in build root
RUN if [ -f "public/build/.vite/manifest.json" ]; then \
        cp public/build/.vite/manifest.json public/build/manifest.json && \
        echo "✓ Copied manifest.json from .vite subdirectory to build root" && \
        echo "Manifest file size: $(wc -c < public/build/manifest.json) bytes" && \
        head -20 public/build/manifest.json || true; \
    elif [ -f "public/build/manifest.json" ]; then \
        echo "✓ Manifest.json already exists in build root"; \
    else \
        echo "WARNING: No manifest.json found in either location"; \
    fi

# Verify build output exists and is complete
RUN echo "Verifying build output..." && \
    ls -la public/build/ && \
    if [ ! -f "public/build/manifest.json" ] && [ ! -f "public/build/.vite/manifest.json" ]; then \
        echo "ERROR: Build failed - manifest.json not found in either location" && exit 1; \
    fi && \
    if [ ! -d "public/build/assets" ]; then \
        echo "ERROR: Build failed - assets directory not found" && exit 1; \
    fi && \
    echo "Build verification successful:" && \
    echo "- Manifest file exists" && \
    echo "- Assets directory exists" && \
    ls -la public/build/assets/ && \
    echo "Build completed successfully!"

# Generate resources manifest file (list of all files in resources directory)
RUN find resources -type f | sort > .resources-manifest.txt

# Clean up node_modules to save space (optional)
RUN rm -rf node_modules

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 755 public/build \
    && chown -R www-data:www-data public/build \
    && chmod -R 644 public/build/manifest.json 2>/dev/null || true \
    && chmod -R 755 resources/views \
    && chown -R www-data:www-data resources/views

# Configure Nginx
RUN rm /etc/nginx/http.d/default.conf
COPY nginx.conf /etc/nginx/http.d/taskware-v2.conf

# Configure PHP-FPM
RUN echo "clear_env = no" >> /usr/local/etc/php-fpm.d/www.conf

# Expose port
EXPOSE 8080

# Copy start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Start services
CMD ["/start.sh"]