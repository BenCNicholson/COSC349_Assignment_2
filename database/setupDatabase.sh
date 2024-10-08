#!/usr/bin/bash
sudo mysql -h $MYSQL_SERVER_IP -u root -pinsecurePW < RoomDB.sql
