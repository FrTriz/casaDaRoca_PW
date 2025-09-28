# 1. IMAGEM BASE
FROM php:8.2-apache

# 2. INSTALAÇÃO DE DEPENDÊNCIAS DE SISTEMA
RUN apt-get update && \
    apt-get install -y \
        libpq-dev \
        build-essential \
        git \
        unzip && \
    rm -rf /var/lib/apt/lists/*

# 3. INSTALAÇÃO DE EXTENSÕES PHP
RUN docker-php-ext-install pdo pdo_pgsql mysqli gd

# 4. INSTALAÇÃO DO COMPOSER
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. CONFIGURAÇÃO DE DIRETÓRIO DE TRABALHO E CÓPIA DE ARQUIVOS
WORKDIR /usr/src/app
COPY . .

# -------------------------------------------------------------
# 6. CONFIGURAÇÃO PERSONALIZADA DO APACHE (Corrige o 404)
# SUBSTITUI o antigo Link Simbólico pela configuração de DocumentRoot/Alias.
# O arquivo '000-default.conf' DEVE estar na raiz do seu projeto Git!

# Remove a configuração padrão do Apache
RUN rm /etc/apache2/sites-available/000-default.conf

# Copia o nosso arquivo de configuração personalizado
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilita o módulo de reescrita (necessário para alguns apps PHP)
RUN a2enmod rewrite
# Habilita o novo arquivo de configuração
RUN a2ensite 000-default.conf
# -------------------------------------------------------------

# 7. INSTALAÇÃO DE DEPENDÊNCIAS DO PROJETO 
# (Mantenha se você usar o Composer)
# RUN composer install --no-dev --optimize-autoloader

# 8. EXPOSIÇÃO DA PORTA
EXPOSE 80