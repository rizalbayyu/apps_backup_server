#!/bin/bash
oldDate=$(date --date="3 days ago" +%Y-%m-%d)

sudo rm /$path/$to/$repo_archieve/backupRepo_$oldDate.tar.gz

sudo mv /$path/$to/$repo_archieve/backupRepo_*.tar.gz /mnt/$external_Storage