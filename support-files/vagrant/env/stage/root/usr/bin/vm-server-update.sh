#!/usr/bin/env bash
sudo cp -R /support-files/vagrant/env/stage/root/* /

sudo sed -i 's/\r$//' /usr/bin/vm-init.sh
sudo sed -i 's/\r$//' /usr/bin/vm-project-update.sh
sudo sed -i 's/\r$//' /usr/bin/vm-server-update.sh
sudo sed -i 's/\r$//' /usr/bin/cass-console.sh
sudo sed -i 's/\r$//' /usr/bin/vm-db-recreate.sh
sudo sed -i 's/\r$//' /usr/bin/vm-db-test.sh

sudo service mongodb restart
sudo service php7.0-fpm restart
sudo service nginx restart