#!/usr/bin/env bash
find /opt/cass/support-files/sql/test -name "*.sql" -exec cat {} \; | mysql -uroot -p"1234" cass_development