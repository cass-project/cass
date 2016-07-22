#!/usr/bin/env bash
sudo cp -R /support-files/vagrant/env/dev/root/* /

sudo sed -i 's/\r$//' /usr/bin/vm-init.sh
sudo sed -i 's/\r$//' /usr/bin/vm-project-update.sh
sudo sed -i 's/\r$//' /usr/bin/vm-server-update.sh
sudo sed -i 's/\r$//' /usr/bin/cass-console.sh
sudo sed -i 's/\r$//' /usr/bin/vm-db-recreate.sh
sudo sed -i 's/\r$//' /usr/bin/vm-db-test.sh
sudo sed -i 's/\r$//' /usr/bin/vm-backend-test.sh

sudo chmod a+x /usr/bin/vm-*
sudo chmod a+x /usr/bin/cass-*

sudo chown -R www-data:www-data /opt/cass

sudo service mysql restart
sudo service mongodb restart
sudo service php7.0-fpm restart
sudo service nginx restart