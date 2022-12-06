#!/bin/bash
date=$(date --date="now" +%Y-%m-%d)

tar -czvf backupRepo_$date.tar.gz /$path/$to/$directory_repo

sudo mv backupRepo_$date.tar.gz /$path/$to/$repo_archieve