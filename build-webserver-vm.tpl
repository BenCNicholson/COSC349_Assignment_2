#!/bin/bash

echo MYSQL_SERVER_IP=${mysql_server_ip} >> /etc/environment

echo "Setup of webserver VM has begun.">/var/log/user.log

apt-get update
apt-get install -y apache2 php libapache2-mod-php php-mysql git mysql-client

cd /var/www/html/
git clone https://github.com/liuja576/COSC349_Assignment2.git 
service apache2 restart
echo "Setup of webserver VM has completed.">/var/log/user.log
