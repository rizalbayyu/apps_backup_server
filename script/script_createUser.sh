#!/bin/bash
USER="devops"
PASSWORD="devops!@#"
DB="repo"

if [ $EUID -ne 0 ]; then
    echo "This script must be run as root. Please Login as root"
    exit 1
else
    echo "Start create user"
    mysql -e "CREATE USER '${USER}'@'localhost' IDENTIFIED BY '${PASSWORD}';"
    sleep 3s
    echo "Done"
    #Jika ingin membuat database dengan user yang telah dibuat, bisa dilakukan dengan cara berikut
    echo "Start create DB"
    mysql -e "CREATE DATABASE ${DB}"
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO '${USER}'@'localhost';" #Grant privileges on all database
    mysql -e "FLUSH PRIVILEGES;"
    sleep 3s
    echo "Done"
fi
