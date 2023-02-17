<?php
include_once("database.php");
if ($_POST['action'] == 'edit' && $_POST['id']) {	
	$updateField='';
	if(isset($_POST['firstName'])) {
		$updateField.= "firstName='".$_POST['firstName']."'";
	} if(isset($_POST['lastName'])) {
		$updateField.= "lastName='".$_POST['lastName']."'";
	}  if(isset($_POST['email'])) {
		$updateField.= "email='".$_POST['email']."'";
	} if(isset($_POST['phoneNumber'])) {
		$updateField.= "phoneNumber='".$_POST['phoneNumber']."'";
	}
	if($updateField && $_POST['id']) {
		$sqlQuery = "UPDATE contacts SET $updateField WHERE id='" . $_POST['id'] . "'";	
		mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));	
		$data = array(
			"message"	=> "Record Updated",	
			"status" => 1
		);
		echo json_encode($data);		
	}
}
if ($_POST['action'] == 'delete' && $_POST['id']) {
	$sqlQuery = "DELETE FROM contacts WHERE id='" . $_POST['id'] . "'";	
	mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));	
	$data = array(
		"message"	=> "Record Deleted",	
		"status" => 1
	);
	echo json_encode($data);	
}
?>