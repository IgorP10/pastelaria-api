FROM php:8.2-fpm

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto
COPY . .

# Dá permissão de escrita na pasta de armazenamento
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Exposição da porta do PHP-FPM
EXPOSE 9000

# Executa o PHP-FPM
CMD ["php-fpm"]
