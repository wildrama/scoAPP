<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'merling8_wildrama');
define('DB_PASSWORD', 'ramiro123cristal');
define('DB_NAME', 'merling8_scorcelliDB');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}



?>