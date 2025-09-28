# 1. IMAGEM BASE
# Usamos uma imagem oficial do PHP com Apache. Use a versão que você usa localmente.
FROM php:8.2-apache

# 2. INSTALAÇÃO DE DEPENDÊNCIAS DE SISTEMA
# 'libpq-dev' é necessário para instalar a extensão do PostgreSQL.
RUN apt-get update && \
    apt-get install -y \
        libpq-dev \
        git \
        unzip && \
    rm -rf /var/lib/apt/lists/*

# 3. INSTALAÇÃO DE EXTENSÕES PHP
# Instala as extensões essenciais para conexão com PostgreSQL (pdo_pgsql)
# e outras comuns.
RUN docker-php-ext-install pdo pdo_pgsql

# 4. INSTALAÇÃO DO COMPOSER (Se você tiver um composer.json)
# Copia o Composer para a pasta PATH do contêiner.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. CONFIGURAÇÃO DE DIRETÓRIO DE TRABALHO
# Define o diretório raiz do seu projeto dentro do contêiner.
WORKDIR /usr/src/app

# 6. CÓPIA DOS ARQUIVOS DO PROJETO
# Copia todo o conteúdo do seu repositório Git para o diretório de trabalho.
COPY . .

# 7. MAPEAMENTO DA RAIZ DO SITE
# Por padrão, o Apache usa /var/www/html/. 
# 
# REMOVER: Remove a pasta padrão do Apache (que contém o index.html de teste)
RUN rm -rf /var/www/html
# 
# LINK: Cria um link simbólico que mapeia sua pasta 'html/' para a raiz do Apache.
# Isso faz com que 'index.php' dentro de 'html/' seja a primeira página a ser carregada.
RUN ln -s /usr/src/app/html /var/www/html

# 8. INSTALAÇÃO DE DEPENDÊNCIAS DO PROJETO (Opcional)
# Se você tiver um composer.json, este comando instala as dependências.
# Se não tiver, comente esta linha.
# RUN composer install --no-dev --optimize-autoloader

# A porta padrão do Apache é a 80. O Render mapeará automaticamente a porta HTTP.
EXPOSE 80