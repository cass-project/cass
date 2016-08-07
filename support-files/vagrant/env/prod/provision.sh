#!/usr/bin/env bash
sudo -i
echo LANG="en_US.UTF-8" >> /etc/environment
echo LANGUAGE="en_US" >> /etc/environment
echo LC_ALL="en_US.UTF-8" >> /etc/environment

cp -R /support-files/vagrant/env/dev/root/usr/bin/cass-* /usr/bin/
cp -R /support-files/vagrant/env/dev/root/usr/bin/vm-* /usr/bin/

chmod a+x /usr/bin/cass-console.sh
chmod a+x /usr/bin/vm-init.sh
chmod a+x /usr/bin/vm-migrate.sh
chmod a+x /usr/bin/vm-backend-test.sh