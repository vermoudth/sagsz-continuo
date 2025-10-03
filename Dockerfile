# Usamos una imagen oficial de PHP 8.2 como base.
# La etiqueta 'bullseye' se refiere a una versión estable de Debian.
FROM php:8.2-cli-bullseye

# Establecemos el directorio de trabajo dentro del contenedor.
WORKDIR /var/www/html

# Instalamos dependencias del sistema necesarias para las extensiones de PHP y Composer.
# -yq suprime las preguntas de confirmación.
RUN apt-get update && apt-get install -yq \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalamos las extensiones de PHP que Laravel comúnmente necesita.
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Descargamos e instalamos Composer (el manejador de paquetes de PHP).
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiamos solo los archivos de dependencias primero.
# Esto aprovecha la caché de Docker: si no cambian, no se re-ejecuta composer install.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader

# Ahora copiamos el resto de los archivos de la aplicación al contenedor.
COPY . .

# Generamos el archivo de entorno a partir del de ejemplo.
# En Render, las variables reales se inyectarán después.
RUN cp .env.example .env

# Generamos la clave de la aplicación.
RUN php artisan key:generate

# Damos los permisos correctos a las carpetas de storage y bootstrap/cache.
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Exponemos el puerto 8000 (el puerto por defecto de 'php artisan serve').
# Render mapeará su puerto interno a este.
EXPOSE 8000

# El comando por defecto para iniciar la aplicación.
# Render puede sobreescribir esto con su propio "Start Command".
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
