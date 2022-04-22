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
        <nav>
            <ul>
                <li>
                    <a href=index.php>KNIHOVNA</a>
                </li>
                <?php
                if(isset($_SESSION['user'])) {
                    if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
                ?>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Přidání</button>
                        <div class="dropdown-content">
                            <a href=addBook.php>Přidat knihu</a>
                            <a href=importCSV.php>Import knih</a>
                            <?php

                            if(unserialize($_SESSION['user'])->getRole() == 3) {
                            ?>

                            <a href=addUser.php>Přidat uživatele</a>
                            <a href=importCSVUsers.php>Import uživatelů</a>
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
                            <a href=allBorrowings.php>Všechny výpůjčky</a>
                            <a href=allLastingBorrowings.php>Všechny trvalé výpůjčky</a>
                            <a href=allAuthors.php>Všichni autoři</a>
                            <?php
                            }
                            ?>
                            <a href=allBooks.php>Všechny knihy</a>
                            <?php
                            if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
                            ?>
                            <a href=allPublicationPlaces.php>Všechna místa vydání</a>
                            <a href=allPublishers.php>Všichni vydavatelé</a>
                            <a href=allSellers.php>Všechni prodejci</a>
                            <a href=allUDCs.php>Všechna mezinárodní desetinná třídění</a>
                            <a href=allSignatures.php>Všechny signatury</a>
                            <a href=allImperfections.php>Všechny závady</a>
                            <a href=allUsers.php>Všichni uživatelé</a>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </li>
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