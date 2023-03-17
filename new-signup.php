<?php
    $nameErr = $emailErr = $passwordErr = $passMatchErr = "";
    $username = $email = "";
    $formValid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["userName"])){
        $nameErr = "Name is required";
        $formValid = false;
    }else {
        $username = test_input($_POST["userName"]);
    }

    else if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $emailErr = "Valid email is required";
        $formValid = false;
    }else {
        $email = test_input($_POST["email"]);
    }

    else if ( ! preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/i", $_POST["password"])) {
        $passwordErr = "Valid password is required";
        $formValid = false;
    }

    else if ($_POST["password"] !== $_POST["password_confirmation"]) {
        $passMatchErr = "Passwords must match";
        $formValid = false;
    }

}
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }


?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/js/validation.js" defer></script>
    <style>
        p.space{
            margin-top: 8px;
        }

        .error{
            color: #FF0000;
        }
    </style>
</head>
<body style = "background-color:#E6E6FA;" >



<div class="container my-5 mx-5"> 
    <h1>Signup</h1>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="signup" novalidate>
        <div>
            <label for="userName">Username</label>
            <input type="text" id="userName" name="userName" value = "<?php echo $username;?>">
            <span class="error">* <?php echo $nameErr;?></span><br>
        </div>
        
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value = "<?php echo $email;?>">
            <span class="error">* <?php echo $emailErr;?></span><br>
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <span class="error">* <?php echo $passwordErr;?></span><br>
            <p>Required:</p>
            <p>8 or more characters</p>
            <p>1 or more letters</p>
            <p>1 or more numbers</p>
        </div>
        
        <div>
            <label for="password_confirmation">Confirm password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
            <span class="error">* <?php echo $passMatchErr;?></span><br>
        </div>
        
        <button>Sign up</button>
    </form>

    <p class="space">Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>

<?php
 if (empty($_POST["userName"])){
    $nameErr = "Name is required";
    $formValid = false;
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    $emailErr = "Valid email is required";
    $formValid = false;
}

if ( ! preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/i", $_POST["password"])) {
    $passwordErr = "Valid password is required";
    $formValid = false;
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    $passMatchErr = "Passwords must match";
    $formValid = false;
}
?>

<?php
if($formValid == true)
{
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $mysqli = require __DIR__ . "/database.php";

    $sql = "INSERT INTO users (userName, email, password_hash)
            VALUES (?, ?, ?)";
            
    $stmt = $mysqli->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sss",
                    $_POST["userName"],
                    $_POST["email"],
                    $password_hash);
                    
    if ($stmt->execute()) {

        header("Location: signup-success.html");
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












