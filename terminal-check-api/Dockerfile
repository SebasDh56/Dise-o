# Usar una imagen base oficial de PHP con extensions necesarias
FROM php:latest

# Configurar entorno para evitar problemas de red
RUN echo "Acquire::http::Timeout \"30\";" > /etc/apt/apt.conf.d/99timeout && \
    echo "Acquire::https::Timeout \"30\";" >> /etc/apt/apt.conf.d/99timeout && \
    apt-get update -o Acquire::Check-Valid-Until=false && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Copiar archivos del proyecto
WORKDIR /var/www
COPY . .

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-scripts --no-interaction

# Configurar permisos
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# Exponer el puerto
EXPOSE 8000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]