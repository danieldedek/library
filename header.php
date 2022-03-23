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
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Přidání</button>
                        <div class="dropdown-content">
                            <a href=addAuthor.php>Přidat autora</a>
                            <a href=addBook.php>Přidat knihu</a>
                            <a href=addImperfection.php>Přidat závadu</a>
                            <a href=addPublisher.php>Přidat vydavatele</a>
                            <a href=addUser.php>Přidat uživatele</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Výpis</button>
                        <div class="dropdown-content">
                            <a href=allBooks.php>Všechny knihy</a>
                            <a href=userInfo.php>Info</a>
                        </div>
                    </div>
                </li>
                <li><a href=index.php>Domovská stránka</a></li>
                <?php
                if(isset($_SESSION["user"])) {
                ?>
                <li><p><?php echo unserialize($_SESSION['user'])->getMail(); ?></p></li>
                <li><a href=includes/logOut.inc.php>Odhlásit se</a></li>
                <?php
                }
                else {
                ?>
                <li><a href=signUp.php>Registrovat se</a></li>
                <li><a href=logIn.php>Přihlásit se</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>