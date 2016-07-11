#!/usr/bin/env bash

mysql  -uroot -p"1234" -e "DROP DATABASE cass"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass"
mysql  -uroot -p"1234" -e "DROP DATABASE cass_testing"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass_testing"

cd /opt/cass/src/backend
vendor/bin/phinx migrate -e cass_development
vendor/bin/phinx migrate -e cass_testing
vendor/bin/phinx migrate -e cass_production