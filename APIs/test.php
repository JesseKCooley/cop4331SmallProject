<?php
$servername = "localhost";
$username = "TheBeast";
$password = "WeLoveCOP4331";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    echo "Connection unsuccessful";
  die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>