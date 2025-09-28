# Usa uma imagem oficial do PHP com o servidor Apache
FROM php:8.2-apache

# Instala extensões críticas para o PostgreSQL e outras utilidades
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite

# Copia todos os seus arquivos do repositório para o diretório de serviço web do Apache
COPY . /var/www/html/

# Define as permissões
RUN chown -R www-data:www-data /var/www/html

# Expor a porta 80 (padrão do Apache)
EXPOSE 80

# Comando padrão para iniciar o Apache
CMD ["apache2-foreground"]