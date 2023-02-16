<?php

    $inData = getRequestInfo();

    // Create connection
    $conn = new mysqli("localhost", "root", "?weLOVElamp826", "COP4331");

    // Check connection
    if ($conn->connect_error)
    {
      die("Connection failed: " . $conn->connect_error);
    }
    else
    {

        $stmt = "SELECT firstName, lastName, number, email, userID FROM Contacts";
        $result = $conn->query($stmt);

        if( $result->num_rows > 0  )
        {
            while($row = $result->fetch_assoc()){
		returnWithInfo( $row['firstName'], $row['lastName'], $row['number'], $row['email'], $row['userID']); //Next line?	  
            }
        }
        else
        {
            returnWithError("No Contacts Found");
        }

        $stmt->close();
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
