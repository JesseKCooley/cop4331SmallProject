<?php 

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

$search = $_POST['search'];

$_id = $user["ID"];
$sql2 = "SELECT * FROM contacts WHERE userID='$_id' AND 
        (firstName LIKE '%$search%' OR 
        lastName LIKE '%$search%' OR 
        email LIKE '%$search%' OR
        phoneNumber LIKE '%$search%')";
$result2 =  $mysqli->query($sql2);


$arrVal = array();

if($result2->num_rows > 0)
{
    $i = 1;
    while($rowList = $result2->fetch_assoc())
    {
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

    echo json_encode($arrVal);
}
else
{
    echo "no records found.";
}



