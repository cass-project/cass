#!/usr/bin/env bash

## UTF-8 Locale Issue
sudo locale-gen UTF-8

# ###############
# APT-GET SECTION
# ###############
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get update
sudo apt-get install -y php7.0 php7.0-fpm php7.0-mysql php7.0-curl git npm nginx nginx-extras

# ########
# PHP7-FPM
# ########
rm /etc/php/7.0/fpm/php.ini
ln -s /vagrant/support-files/php7-fpm/php.ini /etc/php/7.0/fpm/php.ini
rm /etc/php/7.0/fpm/pool.d/www.conf
ln -s /vagrant/support-files/php7-fpm/www.conf /etc/php/7.0/fpm/pool.d/www.conf
sudo service php7.0-fpm restart

## #####
## NGINX
## #####
sudo sh -c "echo \"include /vagrant/support-files/nginx/default;\" > /etc/nginx/sites-available/default"
sudo sh -c "echo \"service nginx restart\" > /etc/rc.local"
sudo service nginx restart

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

# #####
# MONGO
# #####

sudo apt-get install mongodb -y
npm install -g mongo-express

rm /etc/mongodb.conf
ln -s /vagrant/support-files/mongo/mongodb.conf /etc/mongodb.conf
service mongodb restart

# #############
# MONGO-EXPRESS
# #############
mkdir /mongo-express
cd /mongo-express
npm install mongo-express
ln -s /vagrant/support-files/mongo-express/config.js /mongo-express/node_modules/mongo-express/config.js

# TODO: auto-startup server
node ./node_modules/mongo-express/app.js &


# ###################
# Configuring backend
# ###################

cd /vagrant/backend/

# Install composer.phar
curl -sS https://getcomposer.org/installer | php
chmod a+x composer.phar
mv composer.phar /usr/bin/
ln -s /usr/bin/composer.phar /usr/bin/composer

# Install composer dependencies
composer.phar install
cp phinx.yml.dist phinx.yml
vendor/bin/phinx migrate

# ###
# NPM
# ###

npm install -g typings webpack live-server

# ####################
# Configuring frontend
# ####################
cd /vagrant/frontend

ln -s /usr/bin/nodejs /usr/bin/node

npm install -g tsd webpack
npm install --no-bin-link
tsd install

webpack

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

########
# UPDATE
########

ln -s /vagrant/support-files/bin/fix-everything.sh /usr/bin/fix-everything.sh
chmod a+x /usr/bin/fix-everything.sh

#########
# PHPUNIT
#########
cd /vagrant/backend
wget https://phar.phpunit.de/phpunit.phar
chmod +x phpunit.phar
mv phpunit.phar /usr/local/bin/phpunit