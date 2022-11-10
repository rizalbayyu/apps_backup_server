#!/bin/bash
olddate=$(date --date="last week" +%Y-%m-%d)

password="devops!@#"

rm /$path/$to/$backup_directory_repo/DBNamaRepo_$olddate.sql

sudo ssh devops@192.168.0.140 "rm /$path/$to/$backup_directory/DBNamaRepo_$olddate.sql"

echo "delete from nama_repo where date='$olddate';" | mysql -u devops -p$password -Drepo 