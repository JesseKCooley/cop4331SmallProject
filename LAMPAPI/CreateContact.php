<?php

    $inData = getRequestInfo();
 
    $userID = $inData["ID"];    // identify which user has this contact
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
 /*       $stmt = $conn->prepare("INSERT into Contacts (firstName, lastName, number, email, userID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisi", $firstName, $lastName, $number, $email, $userID);
        $stmt->execute();
		$stmt->close();
		$conn->close();
*/
      // check if user already exists
        $sql = "SELECT * FROM Contacts WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            returnWithError("Contact already exists.");
        }
        else 
        {
            $stmt = $conn->prepare("INSERT into Contacts (firstName, lastName, number, email, userID) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisi", $firstName, $lastName, $number, $email, $userID);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        
  //          $sql = "INSERT INTO Conacts (FirstName, LastName, PhoneNumber, Email) VALUES ('$firstName', '$lastName', '$number', '$email')";

            if($sql->query($sql) == TRUE)
            {
              echo "Contact has been created";
            }
            else
            {
              echo "Could not add contact";
            }
        }

   //     $conn->close();
        
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
