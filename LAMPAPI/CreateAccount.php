<?php

    $inData = getRequestInfo();

    $id;
    $firstName = $inData["firstName"];
    $lastName = $inData["lastName"];
    $login = $inData["login"];
    $password = $inData["password"];
   
    
    // Create connection
    $conn = new mysqli("localhost", "root", "?weLOVElamp826", "COP4331");

    // check connection
    if( $conn->connect_error )
    {
        returnWithError( $conn->connect_error );
    }
    else
    {
/*
       $stmt = $conn->prepare("INSERT into Users (firstName, lastName, login, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $login, $password);
        $stmt->execute();
		$stmt->close();
		$conn->close();
//		returnWithError("");
   */
     // check if user already exists
        $sql = "SELECT * FROM Users WHERE login = '$login'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            returnWithError("User already exists.");
        }
        else 
        {
         //   $sql = "INSERT INTO Users (firstName, lastName, login, password) VALUES ('$firstName', '$lastName', '$login', '$password')";

            $stmt = $conn->prepare("INSERT into Users (firstName, lastName, login, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $firstName, $lastName, $login, $password);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            if($sql->query($sql) == TRUE)
            {
              echo "Account has been created";
            }
            else
            {
              echo "Could not create account";
            }
        }
  //      $conn->close();
      
    }


    function getRequestInfo()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
  
    function sendResultInfoAsJson( $obj )
    {
        header('Content-type: application/json');
        echo $obj;
    }
    
    function returnWithError( $err )
    {
        $retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
        sendResultInfoAsJson( $retValue );
    }
    
    function returnWithInfo( $firstName, $lastName, $id )
    {
        $retValue = '{"returnWithInfo: id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
        sendResultInfoAsJson( $retValue );
    }
?>
