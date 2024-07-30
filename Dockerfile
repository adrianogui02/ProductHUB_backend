# Use a imagem oficial do PHP com Apache, versão 8.2
FROM php:8.2-apache

# Defina o diretório de trabalho
WORKDIR /var/www

# Copie todos os arquivos do projeto para o contêiner
COPY . /var/www

# Defina o DocumentRoot para o Apache
RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/apache2.conf

# Instale extensões PHP necessárias e dependências adicionais
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Permitir a execução do Composer como superusuário e instale as dependências do Laravel
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install

# Defina permissões para a pasta storage e bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Exponha a porta 80
EXPOSE 80

# Comando de inicialização
CMD ["apache2-foreground"]
