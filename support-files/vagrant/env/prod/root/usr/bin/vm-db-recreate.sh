#!/usr/bin/env bash

mysql  -uroot -p"1234" -e "DROP DATABASE cass_development"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass_development"
mysql  -uroot -p"1234" -e "DROP DATABASE cass_testing"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass_testing"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass_production"

cd /opt/cass/backend
php /opt/cass/backend/vendor/bin/phinx migrate -e cass_development
php /opt/cass/backend/vendor/bin/phinx migrate -e cass_testing
php /opt/cass/backend/vendor/bin/phinx migrate -e cass_production