# 卒業研究　デザイン比較システム
 
Laravel 6.20.36

## アブストラクト

https://github.com/kazmaItooou/Design-compare-System/blob/main/ep18009%E4%BC%8A%E8%97%A4%E5%92%8C%E7%9C%9F%E3%82%A2%E3%83%96%E3%82%B9%E3%83%88.pdf

# ローカル環境構築方法

GitHubからクローン

```
git clone https://github.com/kazmaItooou/Design-compare-System.git
```

ディレクトリに移動する．以降ディレクトリで作業する．

```
cd Design-compare-System/
```

## Dockerコンテナに入って立ち上げる準備

```
docker-compose up -d --build
docker exec -it dc_app bash
composer install
php artisan migrate
```
http://localhost/
で画面が出て最後まで実験できれば完了


# 本場環境導入方法
前提として，サーバにUbuntu 20.04.3 LTS がインストールされている必要がある．

以下にその後の手順を示す．

## パッケージを更新して日本語環境にする．

```
sudo apt update && sudo apt upgrade -y

sudo apt install language-pack-ja-base language-pack-ja ibus-mozc -y

localectl set-locale LANG=ja_JP.UTF-8 LANGUAGE="ja_JP:ja"

source /etc/default/locale
```

## 必要なリポジトリとzip，unzip を追加する

```
sudo add-apt-repository ppa:ondrej/php -y

sudo apt update && sudo apt upgrade -y

sudo apt install software-properties-common zip unzip -y
```

## Apache2 とphp8.0 と必要と必要なライブラリをインストールする．

```
sudo apt install apache2

sudo apt install php8.0-mysql php-common php8.0-common php8.0 php8.0-mbstring

php-json php8.0-bcmath php8.0-xml php8.0-zip -y
```

## Web サーバ公開に必要なファイヤーウォールルールを追加する．

```
sudo ufw enable -y

sudo ufw allow 22

sudo ufw allow 'Apache'
```

## MySQL をインストール

```
sudo apt-get install mysql-server mysql-client -y
```

## MySQL にroot でログイン

```
mysql -u root -p
```

## Laravel 用のDB”laravel_sotuken”とローカル専用ユーザ”Laravel”を作成する．そして，ユーザに追加したDB の全権限を付与する．

```
create database laravel_sotuken;

SELECT user, host, plugin FROM mysql.user;

CREATE USER laravel@localhost IDENTIFIED WITH mysql_native_password BY
'W4t7xQTuGL5w';

SELECT user, host, plugin FROM mysql.user;

grant all privileges on laravel_sotuken.* to 'laravel'@'localhost';

quit;
```

## Apache のファイルを設定するために，apache のディレクトリに移動．

```
cd /etc/apache2/
```

### apache2.conf を編集する．

```
vi apache2.conf
```

#### 以下の内容を追加する．

```
<Directory /var/www/html/ Design-compare-System/public>

Options Indexes FollowSymLinks

AllowOverride All

\# Allow open access:

Require all granted

</Directory>
```

## Web サーバのドキュメントルートを変更する．

```
cd sites-available

vi 000-default.conf
```

### \#DocumentRoot を以下のように変更する．

```
DocumentRoot /var/www/html/ Design-compare-System/public
```

## Laravel に必要な設定を追加し，apache を再起動する．

```
sudo a2enmod rewrite

sudo service apache2 restart
```

## Apache の設定が終わったので，home ディレクトリからドキュメントルートに移動できる
ように，シンボリックリンクを作成する．そのまま，カレントディレクトリをドキュメント
ルートにする．

```
cd

ln -s /var/www apache

cd apache/html
```

## Laravel をインストールするためにcomposer をダウンロードして，bin に移動しておく．

```
curl -sS https://getcomposer.org/installer | php

mv ./composer.phar /usr/local/bin/composer
```

## ソースコードをgit からダウンロードするか，パソコンから持ってくるかして，カレントデ
ィレクトリに用意する．

```
git clone https://github.com/kazmaItooou/Design-compare-System.git
```

## Laravel のディレクトリに移動する．以降はLaravel のディレクトリで作業する．

```
cd Design-compare-System/
```

## Ubuntu 環境ではこのまま動かすことができないので，権限を付与する．

```
sudo chown -R $USER:www-data storage

sudo chown -R $USER:www-data bootstrap/cache

chmod -R 777 storage

chmod -R 777 bootstrap/cache
```

## Ubuntu 環境ではこのまま動かすことができないので，.htaccess を編集する．

```
cd public

vi .htaccess
```

＃以下を追加

```
Options +FollowSymLinks -Indexes
```

## composer でLaravel 本体をインストールする．

```
composer install

composer update
```

## .env.example を元に，.env を追加する．

```
cp .env.example .env

vi .env
```

### #編集内容は以下である．APP_URL はサーバに合わせる．

```
APP_ENV=production

APP_DEBUG=false

APP_URL=http:// example.com/

DB_DATABASE=laravel_sotuken

DB_USERNAME=laravel

DB_PASSWORD=W4t7xQTuGL5w
```

## Laravel のキャッシュなどをクリアする．

```
php artisan cache:clear; php artisan config:clear; php artisan route:clear; php artisan

view:clear; composer dump-autoload
```

## データベースにテーブルを追加するためにmigrate する．

このコマンドを実行すると"/database/migrations" ディレクトリ内のテーブル追加プログラムが実行され，テーブルが自
動で作られる．

```
php artisan migrate
```

終了．これで，URL を開くと比較システムのアンケート画面が表示される．
