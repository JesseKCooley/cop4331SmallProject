
<?php 

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>

<!-- to disaply table -->
<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.min.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/js/validation.js" defer></script>

    <style>
        table{
            border: 2px solid black;
        }
        th, td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th{
            background-color: #d3d3d3;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:nth-child(odd) {
            background-color: #ffffff;
        }

    </style>
</head>

<body style = "background-color:#E6E6FA;" >

<div class="container my-3">

<?php
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
    while($row = $result2->fetch_assoc())
    {
        $table = array(
              //  'num' => $i,
              //  'id' => $row['id'],
                'First Name'=> $row['firstName'],
                'Last Name'=> $row['lastName'],
                'Email'=>$row['email'],
                'Phone Number'=>$row['phoneNumber'],
                //'dateCreated'=>$row['dateAdded']
                );

                array_push($arrVal, $table);

                $i++;
    }

    ?>

<div class="container my-3">
    <h1>Search Results</h1>

    <?php if (count($arrVal) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th><?php echo implode('</th><th>', array_keys(current($arrVal))); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arrVal as $row): array_map('htmlentities', $row); ?>
                <tr>
                    <td><?php echo implode('</td><td>', $row); ?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endif;?>

    
    <a href="index.php">Home</a>

    <?php
}
else
{
    header("Location: search-fail.html");
   
}

?>






