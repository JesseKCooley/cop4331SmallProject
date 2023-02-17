<?php 



session_start();

if (isset($_POST["id"])) {
    

    $mysqli = require __DIR__ . "/database.php";
    $targ = $_POST["id"];

    $sql = "DELETE FROM contacts WHERE id = '$targ'";
    $result =  $mysqli->query($sql);
    if($result  === TRUE)
    {
       exit;
       
    }
    else 
    { 
        echo "Error removing contact: ".$result->error;
    }
    
    
}

?>   
 