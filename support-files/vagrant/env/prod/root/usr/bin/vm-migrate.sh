#!/usr/bin/env bash

# git pull
cd /opt/cass
git pull && git submodule init && git submodule update && git submodule status

# server software
sudo cp -R /support-files/vagrant/env/prod/root/* /

sudo sed -i 's/\r$//' /usr/bin/cass-console.sh
sudo sed -i 's/\r$//' /usr/bin/vm-init.sh
sudo sed -i 's/\r$//' /usr/bin/vm-migrate.sh
sudo sed -i 's/\r$//' /usr/bin/vm-backend-test.sh

sudo chmod a+x /usr/bin/vm-*
sudo chmod a+x /usr/bin/cass-*

sudo service mysql restart
sudo service mongodb restart
sudo service php7.0-fpm restart
sudo service nginx restart

# backend
cd /opt/cass/src/backend

sudo composer update
sudo composer dump-autoload

php ./vendor/robmorgan/phinx/bin/phinx migrate -e cass
php ./vendor/robmorgan/phinx/bin/phinx migrate -e cass_testing

# database & stage
php ./vendor/bin/phinx migrate
php ./vendor/bin/phinx migrate -e cass_testing
cass-console.sh stage:themes:migrate

# frontend
cd /opt/cass/src/frontend
npm install --no-bin-link
webpack

# chmod
sudo chown -R www-data:www-data /opt/cass
sudo chown -R www-data:www-data /opt/swagger