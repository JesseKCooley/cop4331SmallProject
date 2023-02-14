<?php

$inData = getRequestInfo();

    $id = $inData["ID"];  
    $userID = $inData["userID"];
    $firstName = $inData["firstName"];
    $lastName = $inData["lastName"];
    $number = $inData["number"];
    $email = $inData["email"];
   
    
    // Create connection
    $conn = new mysqli("localhost", "root", "?weLOVElamp826", "COP4331");

    // check connection
    if( $conn->connect_error )
    {
        returnWithError( $conn->connect_error );
    }
    else
    {
        // use number to identify contact and userID to make sure deleting from right user
        $sql = "DELETE FROM Contacts WHERE number = $number AND userID = $userID";  


        if($conn->query($sql) === TRUE)
        {
           echo "Contact removed.";
        }
        else 
        {
            echo "Could not remove contact.";
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
