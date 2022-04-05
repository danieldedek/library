<?php

if((isset($_POST["submit1"])) && (isset($_GET["mail"]))) {

   $newFirstName = htmlspecialchars($_POST["firstName"]);
   $newLastName = htmlspecialchars($_POST["lastName"]);
   $newMail = htmlspecialchars($_POST["mail"]);
   $newPassword = htmlspecialchars($_POST["password"]);
   $newRole = htmlspecialchars($_POST["role"]);
   $oldMail = htmlspecialchars($_GET["mail"]);

   include "./classes/dbh.classes.php";
   include "./classes/updateUser.classes.php";
   include "./classes/updateUser-contr.classes.php";

   $updateUser = new UpdateUserContr($newFirstName, $newLastName, $newMail, $newPassword, $newRole, $oldMail);

   $updateUser->updateUser();
}
?>