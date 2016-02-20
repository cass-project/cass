#!/usr/bin/env bash

# update backend
cd /vagrant/backend
composer.phar install
composer.phar dump-autoload

# update frontend
cd /vagrant/frontend
npm install --no-bin-link
tsd install

# restart services
sudo service php7.0-fpm restart
sudo service nginx restart