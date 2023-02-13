<?php

    $inData = getRequestInfo();

      
    $id = $inData["userID"];
    $firstName = $inData["firstName"];
    $lastName = $inData["lastName"];
    $login = $inData["login"];
    $password = $inData["password"];
   
    
    // Create connection
    $conn = new mysqli("localhost", "root", "welovelamp826", "COP4331");

    // check connection
    if( $conn->connect_error )
    {
        returnWithError( $conn->connect_error );
    }
    else
    {
      // check if user already exists
        $sql = "SELECT * FROM Users WHERE Login = '$login'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            returnWithError("User already exists.");
        }
        else 
        {
            $sql = "INSERT INTO Users (FirstName, LastName, Login, Password) VALUES ('$firstName', '$lastName', '$login', '$password')";

            if($sql->query($sql) == TRUE)
            {
              echo "Account has been created";
            }
            else
            {
              echo "Could not create account";
            }
        }
        $conn->close();
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
        $retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
        sendResultInfoAsJson( $retValue );
    }
?>
