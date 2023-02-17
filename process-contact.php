<?php

if (empty($_POST["firstName"])) {
    die("First name is required");
}

session_start();

$id = 0;
if (isset($_SESSION["user_id"])) {
    $id = $_SESSION["user_id"];
}
$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO contacts (userID, firstName,lastName,email,phoneNumber)
        VALUES (?, ?, ?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sssss",
                  $id,
                  $_POST["firstName"],
                  $_POST["lastName"],
                  $_POST["email"],
                  $_POST["phoneNumber"]
                  );
                  
if ($stmt->execute()) {

    header("Location: createContact-success.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

?>






