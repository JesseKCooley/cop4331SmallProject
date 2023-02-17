<?php

$host = "127.0.0.1";
$dbname = "cop4331";
$username = "root";
$password = "?weLOVElamp826";


$mysqli = new mysqli( $host,
                      $username,
                      $password,
                      $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;
