#!/bin/bash
date=$(date --date="now" +%Y-%m-%d)

password="devops!@#"

mysqldump repo -u devops -p$password > DBNamaRepo_$date.sql

sudo mv DBNamaRepo_$date.sql /$path/$to/$backup_directory_repo

sudo scp -r devops@192.168.0.140:/$path/$to/DBNamaRepo_$date.sql /$path/$to/$backup_directory