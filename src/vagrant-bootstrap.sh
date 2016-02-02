#!/usr/bin/env bash

# ###############
# APT-GET SECTION
# ###############
sudo LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php -y
sudo apt-get update
sudo apt-get purge php5-common -y
sudo apt-get install php7.0 php7.0-fpm php7.0-mysql -y
sudo apt-get --purge autoremove -y

sudo apt-get install npm -y
sudo apt-get install nginx -y

# ##########
# UPDATE NPM
# ##########
npm cache clean -f
npm install -g n
n stable

# #####
# MYSQL
# #####
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password 1234'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 1234'
sudo apt-get install mysql-client mysql-server -y

mysql  -uroot -p"1234" -e "CREATE DATABASE cass_development"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass_stage"

# ###################
# Configuring backend
# ###################

# cd /var/www/app/src/backend

# Install composer.phar
curl -sS https://getcomposer.org/installer | php
chmod a+x composer.phar
mv composer.phar /usr/bin/
ln -s /usr/bin/composer.phar /usr/bin/composer

# Install composer dependencies
cd /vagrant/backend
composer.phar install

# Phinx
chmod a+x ./vendor/bin/phinx
ln -s ./vendor/bin/phinx /usr/bin/phinx

cp phinx.yml.dist phinx.yml
vendor/bin/phinx migrate

# ####################
# Configuring frontend
# ####################
cd /vagrant/frontend

ln -s /usr/bin/nodejs /usr/bin/node

# #######
# SWAGGER
# #######

mkdir /swagger
cd /swagger
git clone https://github.com/swagger-api/swagger-ui.git
cd swagger-ui
npm install
npm run build
cd dist
rm index.html
ln -s /vagrant/support-files/swagger/index.html /swagger/swagger-ui/dist/index.html
ln -s /vagrant/support-files/swagger/style.css /swagger/swagger-ui/dist/style.css
ln -s /vagrant/support-files/swagger/swagger.json /swagger/swagger-ui/dist/swagger.json
cp /
php -S 0.0.0.0:3001 &

# ##########
# RUN SERVER
# ##########
cd /vagrant/www/app
php -S 0.0.0.0:3000 server.php &