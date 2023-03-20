<?php
    $firnameErr = $lasnameErr = $emailErr = $phonenumberErr = "";
    $email = "";
    $firname = $lasname = $email = $number = "";
    $formValid = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["firstname"])){
            $firnameErr = "First name is required";
            $formValid = false;
        }else {
            $firname = test_input($_POST["firstName"]);
        }

        if (empty($_POST["lastname"])){
            $lasnameErr = "Last name is required";
            $formValid = false;
        }else {
            $lasname = test_input($_POST["lastName"]);
        }
       
    
    
        
    
    }

?>



<!DOCTYPE html>
<html>
<head>
    <title>Create Contact</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.min.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/js/contactValidation.js" defer></script>
</head>
<body style = "background-color:#E6E6FA;">
    
    <h1>New Contact</h1>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method= "post" id = "contact" novalidate>
        <div>
            <label for="firstName">First Name</label>
            <span class="error">* <?php echo $firnameErr;?></span>
            <input type="text" id="firstName" name="firstName" value = "<?php echo $firname;?>"><br>
        </div>
        <div>
            <label for="lastName">Last Name</label>
            <span class="error">* <?php echo $lasnameErr;?></span>
            <input type="text" id="lastName" name="lastName" value = "<?php echo $lasname;?>"><br>
        </div>
        <div>
            <label for="email">Email</label>
            <span class="error">* <?php echo $emailErr;?></span>
            <input type="text" id="email" name="email" value = "<?php echo $email;?>"><br>
        </div>
        <div>
            <label for="phoneNumber">Phone Number</label>
            <span class="error">* <?php echo $phonenumberErr;?></span>
            <input type="text" id="phoneNumber" name="phoneNumber" value = "<?php echo $number;?>"><br>
        </div>

        
        <button>Create</button>
    </form>
    
</body>
</html>

<?php
 if (empty($_POST["firstName"])){
    $firnameErr = "First name is required";
    $formValid = false;
}

?>

<?php
if($formValid == true)
{


    session_start();

    $id = 0;
    if (isset($_SESSION["user_id"])) {
        $id = $_SESSION["user_id"];
    }
    $mysqli = require __DIR__ . "/database.php";

    $sql = "INSERT INTO contacts (userID, firstName,lastName,email,phoneNumber)
            VALUES (?, ?, ?, ?, ?)";
            
    $stmt = $mysqli->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sssss",
                    $id,
                    $_POST["firstName"],
                    $_POST["lastName"],
                    $_POST["email"],
                    $_POST["phoneNumber"]
                    );
                    
    if ($stmt->execute()) {

        header("Location: createContact-success.html");
        exit;
        
    } else {
        
        if ($mysqli->errno === 1062) {
            die("email already taken");
        } else {
            die($mysqli->error . " " . $mysqli->errno);
        }
    }
}
?>
