# 1. IMAGEM BASE
FROM php:8.2-apache

# 2. INSTALAÇÃO DE DEPENDÊNCIAS DE SISTEMA
# ADICIONAMOS: libzip-dev, libpng-dev, libjpeg-dev, libfreetype6-dev (necessárias para GD e MySQLi)
RUN apt-get update && \
    apt-get install -y \
        libpq-dev \
        build-essential \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev && \
    rm -rf /var/lib/apt/lists/*

# 3. INSTALAÇÃO DE EXTENSÕES PHP
# MUDAMOS A ORDEM E ADICIONAMOS A CONFIGURAÇÃO DO GD
RUN docker-php-ext-install pdo pdo_pgsql mysqli \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# 4. INSTALAÇÃO DO COMPOSER
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. CONFIGURAÇÃO DE DIRETÓRIO DE TRABALHO E CÓPIA DE ARQUIVOS
WORKDIR /usr/src/app
COPY . .

# 6. CONFIGURAÇÃO PERSONALIZADA DO APACHE
# Copia o arquivo de configuração (para o mapeamento de /php/Funcoes)
RUN rm /etc/apache2/sites-available/000-default.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN a2ensite 000-default.conf

# 7. INSTALAÇÃO DE DEPENDÊNCIAS DO PROJETO 
# (Mantenha se você usar o Composer)
# RUN composer install --no-dev --optimize-autoloader

# 8. EXPOSIÇÃO DA PORTA
EXPOSE 80