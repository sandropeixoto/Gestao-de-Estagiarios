# Stage 1: Build Frontend
FROM node:20 AS frontend-build
WORKDIR /app
COPY frontend/package*.json ./
RUN npm install
COPY frontend/ ./
RUN npm run build

# Stage 2: Production PHP/Apache Image
FROM php:8.2-apache

# Install System Dependencies and PHP Extensions for PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && a2enmod rewrite

# Configure Apache DocumentRoot and Port for Cloud Run
# Cloud Run expects the container to listen on $PORT (default 8080)
# Apache default is 80. We need to patch ports.conf to listen on 8080.
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Copy Backend Source Code to /var/www/html/api
WORKDIR /var/www/html/api
COPY backend/ .

# Copy Frontend Build to /var/www/html
WORKDIR /var/www/html
COPY --from=frontend-build /app/dist .

# Configure Routes using .htaccess (Root level)
# If it's an API request, send to /api/index.php
# Otherwise, serve as static file or fallback to index.html (React Router)
RUN echo '<IfModule mod_rewrite.c>\n\
    RewriteEngine On\n\
    \n\
    # Route /api queries to the backend index.php\n\
    RewriteRule ^api/(.*)$ /api/index.php [L,QSA]\n\
    \n\
    # If file or directory exists, serve it directly\n\
    RewriteCond %{REQUEST_FILENAME} -f [OR]\n\
    RewriteCond %{REQUEST_FILENAME} -d\n\
    RewriteRule ^ - [L]\n\
    \n\
    # Otherwise fallback to index.html (SPA)\n\
    RewriteRule ^ index.html [L]\n\
</IfModule>' > /var/www/html/.htaccess

# Set Default PORT env var for local testing (Cloud Run sets this automatically)
ENV PORT=8080

# Adjust permissions
RUN chown -R www-data:www-data /var/www/html
