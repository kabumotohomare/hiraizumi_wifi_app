# ベースイメージとしてPHP 8.3とComposerをインストール
FROM php:8.3-fpm

# システムパッケージのインストール
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql gd

# Composerのインストール
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# アプリケーションディレクトリを作成
WORKDIR /var/www

# Composerのパッケージをインストール
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# NPMの依存パッケージをインストール
COPY package*.json ./
RUN npm install

# アセットのビルド
#RUN npm run build

# アプリケーションのファイルをコピー
COPY . .

# 最終的なパッケージのインストール
RUN composer dump-autoload --optimize

# 権限の設定
RUN chown -R www-data:www-data /var/www

# PHP-FPMの起動
CMD ["php-fpm"]
