<?php
session_start();
include "./classes/user.php";
?>

<!DOCTYPE html>
<html lang="cs">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <a href=index.php>
            <img src=#>
        </a>
        <nav>
            <ul>
                <li><a href=index.php>Home</a></li>
                <?php
                if(isset($_SESSION["user"])) {
                ?>
                <li><p><?php echo unserialize($_SESSION['user'])->getMail(); ?></p></li>
                <li><a href=includes/logOut.inc.php>LogOut</a></li>
                <?php
                }
                else {
                ?>
                <li><a href=signUp.php>SignUp</a></li>
                <li><a href=logIn.php>LogIn</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>