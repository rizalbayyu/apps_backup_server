# sudo scp -r $1 devops@192.168.0.140:/home/devops/repo_backup
sudo rsync -r $1 devops@192.168.0.140:/home/devops/repo_backup