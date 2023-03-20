<?php
// check for only characters for name
if (empty($_POST["firstName"])) {
    die("First name is required");
}


$mysqli = require __DIR__ . "/database.php";

$uniqueID =  $_POST["id"];
$first = $_POST["firstName"];
$last = $_POST["lastName"];
$email = $_POST["email"];
$phone = $_POST["phoneNumber"];

$sql = "UPDATE contacts SET firstName='$first',lastName='$last',email='$email',phoneNumber='$phone' WHERE id = '$uniqueID'";
        

if ($mysqli->query($sql) === TRUE) {

    exit;
  } else {
    echo "Error updating record: " . $mysqli->error;
  }








