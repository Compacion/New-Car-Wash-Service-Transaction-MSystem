FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    zip \
    unzip \
    git \
    curl \
    vim \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Configure GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP extensions sequentially (more reliable in Codespaces)
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install gd
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure Apache to serve from /workspace/htdocs
ENV APACHE_DOCUMENT_ROOT=/workspace/htdocs
RUN sed -ri -e 's!/var/www/html!/workspace/htdocs!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/workspace/htdocs!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Update Apache configuration for .htaccess support
RUN echo '<Directory /workspace/htdocs>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Set working directory
WORKDIR /workspace

# Expose port 80
EXPOSE 80
