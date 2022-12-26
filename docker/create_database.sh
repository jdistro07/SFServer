#!/bin/bash

# start the MySQL service
/opt/lampp/lampp startmysql

sleep 30

# create demo DB
/opt/lampp/bin/mysql -u root -e "CREATE DATABASE db_scriptforte"
/opt/lampp/bin/mysql -u root db_scriptforte < /opt/lampp/htdocs/sfserver/db/db_scriptforte.sql
/opt/lampp/bin/mysql -u root db_scriptforte < /opt/lampp/htdocs/sfserver/db/db_scriptforte_sampledata.sql

# start the Apache web server
/opt/lampp/lampp start

while true
do
    sleep 100
done