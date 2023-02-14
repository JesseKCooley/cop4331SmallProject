<?php

$inData = getRequestInfo();

      
    $id = $inData["ID"];    
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
  /*      $stmt = $conn->prepare("UPDATE Contacts SET firstName = ?, lastName = ?, number = ?, email = ? WHERE ID = '$id'");
        $stmt->bind_param("ssis", $firstName, $lastName, $number, $email);
        $stmt->execute();
		$stmt->close();
		$conn->close();
*/
        $sql  = "UPDATE Contacts SET 
        firstName = '$firstName', 
        lastName = '$lastName', 
        number = '$number', 
        email = '$email'
        WHERE ID = '$id'";


        if($conn->query($sql) === TRUE)
        {
           echo "Contact information updated successfully.";
        }
        else 
        {
            echo "Could not update contact information.";
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
