#!/usr/bin/env bash

mongo cass --eval "db.dropDatabase()"
mongo cass_testing --eval "db.dropDatabase()"

mysql  -uroot -p"1234" -e "DROP DATABASE cass"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass"
mysql  -uroot -p"1234" -e "DROP DATABASE cass_testing"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass_testing"

cd /opt/cass/src/backend
vendor/bin/phinx migrate -e cass
vendor/bin/phinx migrate -e cass_testing