#!/usr/bin/env bash
find /support-files/sql/test -name "*.sql" -exec cat {} \; | mysql -uroot -p"1234" cass_development