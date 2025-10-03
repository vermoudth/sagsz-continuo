# Usamos una imagen oficial de PHP 8.2 como base.
FROM php:8.2-cli-bullseye

# Establecemos el directorio de trabajo dentro del contenedor.
WORKDIR /var/www/html

# Instalamos dependencias del sistema.
RUN apt-get update && apt-get install -yq \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalamos las extensiones de PHP que Laravel necesita.
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Descargamos e instalamos Composer.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiamos los archivos de dependencias.
COPY composer.json composer.lock ./

# --- INICIA EL CAMBIO IMPORTANTE ---

# Copiamos TODOS los archivos de la aplicación AHORA,
# para que 'artisan' esté disponible para los scripts de Composer.
COPY . .

# Ejecutamos composer install DESPUÉS de que todos los archivos están presentes.
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader

# --- TERMINA EL CAMBIO IMPORTANTE ---

# Generamos el archivo de entorno a partir del de ejemplo.
RUN cp .env.example .env

# Generamos la clave de la aplicación.
RUN php artisan key:generate

# Damos los permisos correctos a las carpetas.
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Exponemos el puerto 8000.
EXPOSE 8000

# El comando por defecto para iniciar la aplicación.
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
