
<?php

$inData = getRequestInfo();

$id = 0;
$username = "";
$email = "";

$conn = new mysqli("127.0.0.1", "root", "?weLOVElamp826", "cop4331"); 	
if( $conn->connect_error )
{
    returnWithError( $conn->connect_error );
}
else
{
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email=?");
    $stmt->bind_param("s", $inData["email"]);
    $stmt->execute();
    $result = $stmt->get_result();

    // (password_verify($_POST["password"], $user["password_hash"])) && 
    if ($row = $result->fetch_assoc()  )
    {
        returnWithInfo( $row['userName'], $row['password_hash'], $row['ID'] );
    }
    else
    {
        returnWithError("No Records Found");
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
    $retValue = '{"id":0,"userName":"","email":"","error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
}

function returnWithInfo( $firstName, $lastName, $id )
{
    $retValue = '{"id":' . $id . ',"userName":"' . $username . '","email":"' . $email . '","error":""}';
    sendResultInfoAsJson( $retValue );
}

?>
