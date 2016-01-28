#!/usr/bin/env bash

# ###############
# APT-GET SECTION
# ###############
apt-get install -y gem nodejs npm
apt-get install -y php5 php5-curl php5-cli php5-fpm php5-imagick php5-json php5-memcache php5-xdebug

#sudo LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php
#sudo apt-get update
#sudo apt-get purge php5-common -y
#sudo apt-get install php7.0 php7.0-fpm php7.0-mysql -y
#sudo apt-get --purge autoremove -y

# ##########
# UPDATE NPM
# ##########
npm cache clean -f
npm install -g n
n stable

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
ln -s ./bin/phinx /usr/bin/phinx

# ####################
# Configuring frontend
# ####################
cd /vagrant/frontend

ln -s /usr/bin/nodejs /usr/bin/node

# ##########
# RUN SERVER
# ##########
cd /vagrant/www/app
php -S 0.0.0.0:3000 server.php &