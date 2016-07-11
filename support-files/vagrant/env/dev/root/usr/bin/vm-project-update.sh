#!/usr/bin/env bash

# backend
cd /opt/cass/src/backend

composer update
composer dump-autoload

php ./vendor/robmorgan/phinx/bin/phinx migrate -e cass
php ./vendor/robmorgan/phinx/bin/phinx migrate -e cass_testing

# frontend
cd /opt/cass/src/frontend
npm install --no-bin-link
webpack

# chmod
sudo chown -R www-data /opt/cass
sudo chown -R www-data /opt/swagger