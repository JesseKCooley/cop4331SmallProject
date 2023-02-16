<?php

	$inData = getRequestInfo();
	
	$searchResults = "";
	$searchCount = 0;

	$conn = new mysqli("localhost", "root", "?weLOVElamp826", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		
// NEEDS TO BE EDITED vvvvv
		
	    /* 	$contactName = "%" . $inData["search"] . "%";
		$sql = "SELECT * FROM Contacts WHERE firstName = '$contactName'"
		$result->$conn->query($sql);
		if($result->num_rows > 0) {
  		   while($row = $result->fetch_assoc()){
			returnWithInfo( $row['firstName'], $row['lastName'], $row['number'], $row['email'], $row['userID']); //Next line?
		   }
		}
		else {
  		 returnWithError("No Contacts Match");
		}
		
		Maybe? */
		
		$stmt = $conn->prepare("select Name from Contacts where Name like ? and UserID=?");
		$contactName = "%" . $inData["search"] . "%";
		$stmt->bind_param("ss", $contactName, $inData["userId"]);
		$stmt->execute();
		
		$result = $stmt->get_result();
		
		while($row = $result->fetch_assoc())
		{
			if( $searchCount > 0 )
			{
				$searchResults .= ",";
			}
			$searchCount++;
			$searchResults .= '"' . $row["Name"] . '"';
		}
		
// NEEDS TO BE EDITED ^^^^^^^
		
		if( $searchCount == 0 )
		{
			returnWithError( "No Records Found" );
		}
		else
		{
			returnWithInfo( $searchResults );
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
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
