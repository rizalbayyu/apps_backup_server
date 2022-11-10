# sudo scp -r devops@192.168.0.140:/home/devops/repo_backup/$1 /home/rizal/repo/
sudo rsync -r devops@192.168.0.140:/home/devops/repo_backup/$1 /home/rizal/repo/
