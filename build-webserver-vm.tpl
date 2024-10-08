#!/bin/bash

echo MYSQL_SERVER_IP=${mysql_server_ip} >> /etc/environment

echo "Setup of webserver VM has begun.">/var/log/user.log

apt-get update
apt-get install -y apache2 php libapache2-mod-php php-mysql git mysql-client expect

cd /home
sudo git clone https://github.com/BenCNicholson/COSC349_Assignment_2.git main
sudo mv main/ /var/www/

#Copying our new config file
sudo cp /var/www/main/webserver.conf /etc/apache2/sites-available/
sudo a2ensite webserver
sudo a2dissite 000-default
service apache2 restart
echo "Setup of webserver VM has completed.">/var/log/user.log

sudo chmod +x /var/www/main/database/setupDatabase.sh
cd ./var/www/main/database/setupDatabase.sh

