FROM php:8.2-cli
WORKDIR /app
COPY . /app
RUN apt-get update && \
  apt-get install -y libpq-dev git unzip && \
  docker-php-ext-install pdo pdo_pgsql
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install PHP CS Fixer globally
RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v3.phar -o /usr/local/bin/php-cs-fixer \
  && chmod +x /usr/local/bin/php-cs-fixer
EXPOSE 8000

