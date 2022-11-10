#!/bin/bash
USER="devops"
PASSWORD="devops!@#"
DB="repo"

if [ $EUID -ne 0 ]; then
    echo "This script must be run as root. Please Login as root"
    exit 1
else
    mysql -e "SET GLOBAL validate_password.length = 6;"
    mysql -e "SET GLOBAL validate_password.number_count = 0;"
    mysql -e "SET GLOBAL validate_password.policy = 0;"
    echo "Start create user"
    mysql -e "CREATE USER '${USER}'@'localhost' IDENTIFIED BY '${PASSWORD}';"
    mysql -e "CREATE USER '${USER}'@'%' IDENTIFIED BY '${PASSWORD}';"
    sleep 3s
    echo "Done"
    #Jika ingin membuat database dengan user yang telah dibuat, bisa dilakukan dengan cara berikut
    echo "Start create DB"
    mysql -e "CREATE DATABASE ${DB}"
    mysql -e "GRANT ALL PRIVILEGES ON ${DB}.* TO '${USER}'@'localhost';" #Grant privileges on specific database
    mysql -e "GRANT ALL PRIVILEGES ON ${DB}.* TO '${USER}'@'%';" #Grant privileges on specific database
    mysql -e "FLUSH PRIVILEGES;"
    sleep 3s
    mysql -D ${DB} -e "CREATE TABLE nama_repo (repo_id VARCHAR(128) NOT NULL UNIQUE, date VARCHAR(128) NOT NULL, time VARCHAR(128) NOT NULL, last VARCHAR(128));"
    echo "Done"
fi
