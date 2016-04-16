#!/usr/bin/env bash
cp -R /support-files/copy/usr/bin/vm-* /usr/bin/

chmod a+x /usr/bin/vm-server-update
chmod a+x /usr/bin/vm-project-update
chmod a+x /usr/bin/vm-init
chmod a+x /usr/bin/vm-db-test
chmod a+x /usr/bin/vm-db-recreate

sudo sed -i 's/\r$//' /usr/bin/vm-init
sudo sed -i 's/\r$//' /usr/bin/vm-project-update
sudo sed -i 's/\r$//' /usr/bin/vm-server-update
sudo sed -i 's/\r$//' /usr/bin/vm-db-test
sudo sed -i 's/\r$//' /usr/bin/vm-db-recreate

sudo locale-gen UTF-8
echo "LC_ALL=en_US.UTF-8" > /etc/envinroment
echo "LANG=en_US.UTF-8" > /etc/envinroment

sudo usermod -a -G www-data vagrant