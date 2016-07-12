#!/usr/bin/env bash

# Locale issues
sudo apt-get install language-pack-en language-pack-en-base -y
sudo locale-gen en_US.UTF-8
export LC_ALL="en_US.UTF-8"

# ###############
# APT-GET SECTION
# ###############
sudo LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php -y
sudo apt-get update

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password 1234'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 1234'

sudo apt-get install -y curl php7.0 php7.0-fpm php7.0-mysql php7.0-zip php7.0-curl php7.0-xml php7.0-gd php7.0-bcmath php7.0-mbstring php7.0-dom git npm nginx nginx-extras sphinxsearch rabbitmq-server sendmail mysql-client mysql-server mongodb php-pear php7.0-dev pkg-config libssl-dev libsslcommon2-dev

# ##########
# UPDATE NPM
# ##########
sudo npm install -g n
sudo n 5.11.1

# #####
# MYSQL
# #####
mysql -uroot -p"1234" -e "CREATE DATABASE cass"
mysql -uroot -p"1234" -e "CREATE DATABASE cass_testing"

# #############
# MONGO-EXPRESS
# #############
sudo mkdir /opt/mongo-express
cd /opt/mongo-express
sudo npm install -g mongo-express
sudo npm install mongo-express
sudo chown -R www-data /opt/mongo-express

# ##############
# PHP7.0-MONGODB
# ##############
sudo pecl install mongodb

# #######
# Backend
# #######
cd /opt/cass/src/backend/

# Install composer.phar
cd /tmp
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/bin/
sudo chmod a+x /usr/bin/composer.phar
sudo ln -s /usr/bin/composer.phar /usr/bin/composer

# Install composer dependencies
cd /opt/cass/src/backend/
composer.phar install

# error log
sudo touch /var/log/php-errors.log
sudo chown -R www-data /var/log/php-errors.log

# db
cd /opt/cass/src/backend
vendor/bin/phinx migrate -e cass
vendor/bin/phinx migrate -e cass_testing

# ########
# Frontend
# ########
cd /opt/cass/src/frontend

sudo ln -s /usr/bin/nodejs /usr/bin/node

sudo npm install -g typings webpack
npm install
npm rebuild node-sass
typings install

webpack

# #######
# SWAGGER
# #######
sudo mkdir /opt/swagger
cd /opt/swagger
sudo rm -rf swagger-ui/
sudo git clone https://github.com/swagger-api/swagger-ui.git
cd swagger-ui
sudo npm install
sudo npm run build
sudo mv dist api-docs
sudo chown -R www-data /opt/swagger

#########
# PHPUNIT
#########
cd /opt/cass/src/backend
wget https://phar.phpunit.de/phpunit.phar
chmod +x phpunit.phar
sudo mv phpunit.phar /usr/local/bin/phpunit

# #############
# Update server
# #############
vm-server-update.sh

# #####
# NGINX
# #####
sudo ln -s /etc/nginx/sites-available/cass /etc/nginx/sites-enabled/cass
sudo service nginx restart