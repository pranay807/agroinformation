<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: agrohome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: agrohome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; 
            background : url(https://cdn-a.william-reed.com/var/wrbm_gb_food_pharma/storage/images/1/2/6/8/2218621-1-eng-GB/Agribusiness-needs-to-step-up-investment-in-technology-Diamond-V_wrbm_large.jpg);
            background-size:cover;}
        .wrapper{ width: 350px; padding: 25px; }
        .loginbox{	width:400px;
            height:480px;
	position:absolute;
	top:50%;
	left:50%;
	transform: translate(-50%,-50%);
    background-color: rgba(247, 244, 244, 0.4);
padding:25px;
border-radius:8px;
}
    
    header label{
    font-family: Comic Sans MS;
    font-weight: bolder;
    font-size: 2.5em;
    font-style: italic;
    padding-left: 20px;
    color:white;
}

.loginbox h1{
	font-size:40px;
    margin-bottom:50px;
}
.form-group{
    padding-bottom:5px;
}

.form-group input{
    border:solid 2px #fff;
	background: none;
	font-size:18px;
	width:100%;
}

.form-control{
    padding:10px;
}

.btn1{
    width:100%;
    padding:10px;
}

.btn1 a{
    text-decoration:none;
}
    </style>
</head>
<body>
    <header>
        <label>AgroInfo Center</label>
    </header>
    <div class="wrapper">
        
        <form class="loginbox" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h1>Login</h1>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="email" name="username" placeholder="Enter Username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" placeholder="Enter password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Login">
            </div>
            <p>Don't have an account? <p>
            <button class="btn1"><a href="register3.php">Sign up now</a><button>
        </form>
    </div>    
</body>
</html>