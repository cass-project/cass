#!/usr/bin/env bash
cp -R /support-files/copy/usr/bin/vm-init /usr/bin/
cp -R /support-files/copy/usr/bin/vm-server-update /usr/bin/
cp -R /support-files/copy/usr/bin/vm-project-update /usr/bin/

chmod a+x /usr/bin/vm-server-update
chmod a+x /usr/bin/vm-project-update
chmod a+x /usr/bin/vm-init

sudo sed -i 's/\r$//' /usr/bin/vm-init
sudo sed -i 's/\r$//' /usr/bin/vm-project-update
sudo sed -i 's/\r$//' /usr/bin/vm-server-update