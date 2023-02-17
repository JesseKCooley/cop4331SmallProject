<?php

$host = "138.197.120.41"; //this was once "localhost" and I'm not sure if it's supposed to be that or our server's IP address...?
$dbname = "cop4331";
$username = "root";
$password = "?weLOVElamp826";


$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;
?>
