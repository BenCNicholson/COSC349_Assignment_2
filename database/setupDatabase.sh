#!/usr/bin/bash
sudo mysql -h $MYSQL_SERVER_IP -u root -pinsecurePW < /var/www/main/database/RoomDB.sql
