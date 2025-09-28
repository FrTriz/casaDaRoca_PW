# 1. IMAGEM BASE
# Usamos a imagem oficial do PHP com Apache na versão 8.2 para estabilidade e recursos modernos.
FROM php:8.2-apache

# 2. INSTALAÇÃO DE DEPENDÊNCIAS DE SISTEMA
# 'libpq-dev' é essencial para o driver PostgreSQL.
# 'build-essential' ajuda na compilação e resolve dependências comuns.
RUN apt-get update && \
    apt-get install -y \
        libpq-dev \
        build-essential \
        git \
        unzip && \
    rm -rf /var/lib/apt/lists/*

# 3. INSTALAÇÃO DE EXTENSÕES PHP
# Instala o driver PDO para PostgreSQL (pdo_pgsql) e garante que o módulo base PDO seja carregado.
# Adicionamos 'mysqli' por garantia, pois é comum e não custa nada.
RUN docker-php-ext-install pdo pdo_pgsql mysqli

# 4. INSTALAÇÃO DO COMPOSER
# Instala o Composer, que é o gerenciador de pacotes do PHP.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. CONFIGURAÇÃO DE DIRETÓRIO DE TRABALHO E CÓPIA DE ARQUIVOS
# Define a pasta /usr/src/app como a pasta de trabalho do projeto.
WORKDIR /usr/src/app
# Copia todo o código do seu repositório Git para o contêiner.
COPY . .

# 6. MAPEAMENTO DA RAIZ DO SITE (Document Root)
# Esta é a parte crítica para sua estrutura de pastas:
# a) Remove a pasta padrão do Apache.
RUN rm -rf /var/www/html
# b) Cria um link simbólico, apontando a raiz web do Apache para a sua pasta 'html/'.
# Isso faz com que seus arquivos de frontend sejam servidos corretamente.
RUN ln -s /usr/src/app/html /var/www/html

# 7. INSTALAÇÃO DE DEPENDÊNCIAS DO PROJETO (Se você usar Composer)
# Se você tiver um arquivo composer.json, esta linha instala suas dependências.
# Se não usar, comente ou remova esta linha.
# RUN composer install --no-dev --optimize-autoloader

# 8. EXPOSIÇÃO DA PORTA
# Define a porta padrão. O Render fará o mapeamento automaticamente.
EXPOSE 80