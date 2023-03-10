<?php 

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}
$_id = $user["ID"];
$sql2 = "SELECT * FROM contacts WHERE userID='$_id'";
$result2 =  $mysqli->query($sql2);

$arrVal = array();
 		
	$i=1;
 	while ($rowList = $result2->fetch_assoc()) {
 								 
						$name = array(
								'num' => $i,
								'id' => $rowList['id'],
 	 		 	 				'first'=> $rowList['firstName'],
	 		 	 				'last'=> $rowList['lastName'],
                                'email'=>$rowList['email'],
                                'phone'=>$rowList['phoneNumber'],
							'dateCreated'=>$rowList['dateAdded']
 	 		 	 			);		


							array_push($arrVal, $name);	
			$i++;			
	 	}
	 		 echo  json_encode($arrVal);		
 
 
