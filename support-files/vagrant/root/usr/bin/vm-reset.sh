#!/usr/bin/env bash

export LC_ALL="en_US.UTF-8"

mongo cass --eval "db.dropDatabase()"
mongo cass_testing --eval "db.dropDatabase()"
mongo cass_production --eval "db.dropDatabase()"
mongo cass_development --eval "db.dropDatabase()"

mysql  -uroot -p"1234" -e "DROP DATABASE cass"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass"
mysql  -uroot -p"1234" -e "DROP DATABASE cass_testing"
mysql  -uroot -p"1234" -e "CREATE DATABASE cass_testing"

/usr/bin/vm-migrate.sh