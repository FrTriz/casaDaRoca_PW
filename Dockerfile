# Usa a imagem oficial do PHP com o servidor Apache
FROM php:8.2-apache

# Instala extensões críticas para o PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite

# CRÍTICO: Copia o conteúdo das pastas para a raiz do servidor web (/var/www/html/)
# Isso garante que a estrutura 'php/', 'css/', e 'img/' seja mantida.
COPY html/ /var/www/html/
COPY php/ /var/www/html/php/
COPY css/ /var/www/html/css/
COPY img/ /var/www/html/img/
COPY script.js /var/www/html/script.js

# Define as permissões
RUN chown -R www-data:www-data /var/www/html

# Inicia o Apache
CMD ["apache2-foreground"]