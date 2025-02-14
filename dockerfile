FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip libzip-dev \
    && apt-get clean

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql zip
# Install Node.js 18
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs
    
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel project files
COPY . .

# Nginx Configuration
COPY nginx/default.conf /etc/nginx/conf.d/

# Expose port 80 for HTTP
EXPOSE 80
EXPOSE 8080

# Start PHP-FPM and Nginx
CMD service nginx start && php-fpm
