<?php 
$db_host = getenv('MYSQL_SERVER_IP');
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
    echo "connect :)";
}
?>