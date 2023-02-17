<?php

$host = "127.0.0.1";
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
