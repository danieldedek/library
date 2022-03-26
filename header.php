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
                <?php
                if(isset($_SESSION['user'])) {
                    if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
                ?>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Přidání</button>
                        <div class="dropdown-content">
                            <a href=addAuthor.php>Přidat autora</a>
                            <a href=addBook.php>Přidat knihu</a>
                            <a href=addImperfection.php>Přidat závadu</a>
                            <a href=addPublisher.php>Přidat vydavatele</a>
                            <?php

                            if(unserialize($_SESSION['user'])->getRole() == 3) {
                            ?>

                            <a href=addUser.php>Přidat uživatele</a>
                        </div>
                    </div>
                </li>
                <?php
                    }
                }
                ?>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Výpis</button>
                        <div class="dropdown-content">
                        <?php
                        if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
                        ?>
                            <a href=allAuthors.php>Všichni autoři</a>
                            <?php
                            }
                            ?>
                            <a href=allBooks.php>Všechny knihy</a>
                            <?php
                            if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
                            ?>
                            <a href=allImperfections.php>Všechny závady</a>
                            <a href=allPublishers.php>Všichni vydavatelé</a>
                            <a href=allUsers.php>Všichni uživatelé</a>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </li>
                <li><a href=index.php>Domovská stránka</a></li>
                <?php
                if(isset($_SESSION["user"])) {
                ?>
                <li><a href=userInfo.php><?php echo unserialize($_SESSION['user'])->getMail(); ?></a></li>
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