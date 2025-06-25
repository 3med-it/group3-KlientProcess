FROM mcr.microsoft.com/devcontainers/php:8.1

# Node.js & Yarn (für Assets)
RUN apt-get update \
 && apt-get install -y curl gnupg2 \
 && curl -sL https://deb.nodesource.com/setup_16.x | bash - \
 && apt-get install -y nodejs \
 && npm install -g yarn

# Symfony CLI (optional)
RUN curl -sS https://get.symfony.com/cli/installer | bash \
 && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Composer self-update
RUN composer self-update --2

WORKDIR /workspace
