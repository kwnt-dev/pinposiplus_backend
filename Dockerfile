FROM php:8.4-cli

# 必要なパッケージインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Laravel開発サーバー起動
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
