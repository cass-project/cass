#!/usr/bin/env bash
sudo -i
echo LANG="en_US.UTF-8" >> /etc/environment
echo LANGUAGE="en_US" >> /etc/environment
echo LC_ALL="en_US.UTF-8" >> /etc/environment

cp -R /support-files/vagrant/root/usr/bin/vm-* /usr/bin/
cp -R /support-files/vagrant/root/usr/bin/cass-* /usr/bin/

sudo sed -i 's/\r$//' /usr/bin/vm-*
sudo sed -i 's/\r$//' /usr/bin/cass-*

chmod a+x /usr/bin/vm-*
chmod a+x /usr/bin/cass-*