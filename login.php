
<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
   // $mysqli = require __DIR__ . "/database.php";
    
   $host = "127.0.0.1";
   $dbname = "cop4331";
   $username = "root";
   $password = "?weLOVElamp826";
   
   
   $mysqli = new mysqli( $host,
                         $username,
                         $password,
                         $dbname);
                        
   if ($mysqli->connect_errno) {
       die("Connection error: " . $mysqli->connect_error);
   }

    $sql = sprintf("SELECT * FROM users
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
// insert
            if ($row = $result->fetch_assoc()  )
            {
                returnWithInfo( $row['userName'], $row['password_hash'], $row['ID'] );
            }
            else
            {
                returnWithError("No Records Found");
            }
// end
            
            $_SESSION["user_id"] = $user["ID"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;


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
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        p.space{
            margin-top: 8px;
        }
    </style>

</head>
<body style = "background-color:#E6E6FA;">
<div class="container my-5 mx-5">   
    <h1>Login</h1>
    
    <!-- invalid -->

    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"><br>
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <?php if ($is_invalid): ?>
            <span style="color:red;">*Invalid login</span>
        <?php endif; ?>

        <br>
        <button>Log in</button>

    </form>

    <p class="space">Don't have an account? <a href="new-signup.php">Create Account</a></p>

</div>
</body>
</html>








