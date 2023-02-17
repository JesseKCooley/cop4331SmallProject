<?php

$host = "138.197.120.41/";
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
