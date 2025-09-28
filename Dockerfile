# Usa uma imagem oficial do PHP com o servidor Apache
FROM php:8.2-apache

# Instala extensões críticas para o PostgreSQL e outras utilidades
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite

# CRÍTICO: Copia o conteúdo das pastas para o servidor web do Apache
# 1. Copia o conteúdo principal da pasta 'html' para a raiz do servidor web
COPY html/ /var/www/html/

# 2. Copia a pasta 'php' (que contém Funcoes e Classes) para a raiz do servidor web
# Isso garante que todos os seus caminhos de include, como 'php/Funcoes/conexao.php', funcionem
COPY php/ /var/www/html/php/

# 3. Copia a pasta 'img' para a raiz do servidor web
COPY img/ /var/www/html/img/

# 4. Copia outros arquivos de configuração que estão na raiz (como o script.js e o próprio Dockerfile, se necessário)
COPY script.js /var/www/html/

# Configura permissões de arquivos
RUN chown -R www-data:www-data /var/www/html

# Inicia o Apache (comando padrão)
CMD ["apache2-foreground"]