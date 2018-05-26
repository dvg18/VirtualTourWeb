#!/bin/bash

sudo apt update
sudo apt install mysql-server mysql-client
sudo apt install php7.0-mysql php7.0-curl php7.0-json php7.0 curl php-cli php-mbstring
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer require robmorgan/phinx
composer install --no-dev
mkdir -p db/migrations db/seeds
vendor/bin/phinx init
mysqladmin create -u root -p OFTEAMCHAT
echo 'Set root password for database and then edit phinx.yml and set user and root passwd too for development environment'
vendor/bin/phinx migrate -e development
echo 'Migration command = sudo vendor/bin/phinx migrate -e development'

