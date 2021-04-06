<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login2.php");
    exit;
}
?>
 


<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>AgroInfo Center</title>
        <link rel="stylesheet" href="agrohome.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <header>
            <label>AgroInfo Center</label>
            <nav class="navi">
            <a href="#" class="active">Home</a>
                <a href="info.html">Farming Information</a>
                <a href="gallery.html">Gallery</a>
                <a href="contact.html">Contact</a>
                <a href="logout.php"><i class="fa fa-user" aria-hidden="true"></i>Log Out</a>
            </nav>
        </header>
        </div>       
        <div class="content">
            <div class="content-1">
                Agriculture is an important source of livelihood in most parts of the world.
                It involves tough work but it contributes to food security and health of the nation.
            </div>
        </div>
    </body>
</html>
