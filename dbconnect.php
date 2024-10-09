<?php 
#Definitions, will need to input the ip address after terraform creation
define('MYSQL_SERVER_IP','sql-server.cvo4ama5v09p.us-east-1.rds.amazonaws.com');
define('ADMIN_SERVER_IP','52.54.133.98');
define('WEB_SERVER_IP','54.85.180.208');
#Connect to db
$db_host = MYSQL_SERVER_IP;
$db_name = 'roomDB';
$db_user = 'root';
$db_passwd = 'insecurePW';

$mysqli = mysqli_connect($db_host,$db_user,$db_passwd,$db_name);
// Check connection
if ($mysqli->connect_error) {
    // Connection failed
    echo "Connection failed: " . $mysqli->connect_error;
}else{
    //Debug message :).
}
?>