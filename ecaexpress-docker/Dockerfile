FROM php:8.2-fpm

# Instalar dependencias de PHP + Node.js
RUN apt-get update \
 && apt-get install -y git zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl gnupg \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip gd \
 && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get install -y nodejs \
 && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Clonar el proyecto Laravel y construir
WORKDIR /var/www/html
RUN git clone https://github.com/elmloko/ecaexpress.git . \
 && composer install --no-interaction --optimize-autoloader \
 && cp .env.example .env \
 && php artisan key:generate \
 && npm install \
 && npm run build   # <-- usa 'build' en lugar de 'dev' si es producción

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
