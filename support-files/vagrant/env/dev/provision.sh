#!/usr/bin/env bash
cp -R /support-files/vagrant/env/dev/root/usr/bin/vm-* /usr/bin/
cp -R /support-files/vagrant/env/dev/root/usr/bin/cass-* /usr/bin/

sudo sed -i 's/\r$//' /usr/bin/vm-*
sudo sed -i 's/\r$//' /usr/bin/cass-*

chmod a+x /usr/bin/vm-*
chmod a+x /usr/bin/cass-*