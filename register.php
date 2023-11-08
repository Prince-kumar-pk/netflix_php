

<?php

require_once "config.php";

$username = $password = $email = "";
$username_err = $password_err = $email_err = "";


if($_SERVER['REQUEST_METHOD'] == "POST"){


    if(empty(trim($_POST['username']))) {
        $username_err = "Username cannot be blanck";
    }
    else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"s",$param_username);

            // set the value of param_username 

            $param_username = trim($_POST['username']);

            // execute statment 

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }else{
                echo "Something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }
// check for password


if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}elseif (strlen(trim($_POST['password'])) < 5) {
    $password_err = "Password length should be greater than 5";
}
else{
    $password = trim($_POST['password']);
}

// email validate

if (empty($_POST["email"])) {
    $email_err = "Email is required";
  } else {
    $email = $_POST["email"];
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
    }else{
        $email = trim($_POST['email']);
    }
  }



  //insert into the data base 

  if(empty($username_err) && empty($email_err) && empty($password_err)) {
    $sql = "INSERT INTO users (username,email, password) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if($stmt){
        mysqli_stmt_bind_param($stmt, "sss", $param_username,$param_email, $param_password);

        // set the parameters

        $param_username = $username;
        $param_email = $email;
        $param_password = password_hash($password,PASSWORD_DEFAULT);

        // try to execute the query 

        if(mysqli_stmt_execute($stmt)){
            header("localhost: netflix");
        }
        else{
            echo "something went wrong cannot redirect";
        }
    }
    mysqli_stmt_close($stmt);
  }

mysqli_close($conn);

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css" />
    <title>
        Register
    </title>
</head>
<body>
<div id="signInModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Sign Up to Netflix</h2>
                <form action ="" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <label for="email">Email Id:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Sign Up</button>
                </form>
            </div>
            </div>
        
<script src="./javascript/script.js"></script>
</body>
</html>