# イメージを取得
FROM php:8.3-fpm
# 独自のphp.iniファイル(PHPの設定ファイル)を 
# コンテナ内の/usr/local/etc/php/ディレクトリにコピー
COPY php.ini /usr/local/etc/php/


# パッケージのアップデートと必要なツールのインストール
RUN apt-get update && apt-get upgrade -y
# RUN apt-get install -y --no-install-recommends software-properties-common python3 python3-pip lsb-release ca-certificates apt-transport-https wget curl git zip unzip && pip3 install --upgrade pip && pip3 install requests lxml

# PPAリポジトリの追加
# RUN add-apt-repository ppa:ondrej/php && apt-get update

# 必要なPHP拡張モジュールのインストール
# RUN apt-get install -y php8.3-bcmath php8.3-ctype php8.3-fileinfo php8.3-json php8.3-mbstring php8.3-openssl php8.3-pdo php8.3-xml php8.3-tokenizer && docker-php-ext-install pdo_mysql

RUN apt-get update && apt-get install -y git curl zip unzip && docker-php-ext-install pdo_mysql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
# 作業ディレクトリを/var/wwwに設定
WORKDIR /src