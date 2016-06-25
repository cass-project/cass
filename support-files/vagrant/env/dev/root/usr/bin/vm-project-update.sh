#!/usr/bin/env bash

# backend
cd /opt/cass/src/backend

composer update
composer install

php ./vendor/robmorgan/phinx/bin/phinx migrate -e cass_development
php ./vendor/robmorgan/phinx/bin/phinx migrate -e cass_testing

# frontend
cd /opt/cass/src/frontend
npm install --no-bin-link
webpack