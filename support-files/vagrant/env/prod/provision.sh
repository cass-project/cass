#!/usr/bin/env bash
cp -R /support-files/vagrant/env/dev/root/usr/bin/vm-* /usr/bin/

sudo sed -i 's/\r$//' /usr/bin/vm-init.sh
sudo sed -i 's/\r$//' /usr/bin/vm-project-update.sh
sudo sed -i 's/\r$//' /usr/bin/vm-server-update.sh
sudo sed -i 's/\r$//' /usr/bin/vm-db-test.sh
sudo sed -i 's/\r$//' /usr/bin/vm-db-recreate.sh

chmod a+x /usr/bin/vm-server-update.sh
chmod a+x /usr/bin/vm-init.sh
chmod a+x /usr/bin/vm-project-update.sh
chmod a+x /usr/bin/vm-db-test.sh
chmod a+x /usr/bin/vm-db-recreate.sh