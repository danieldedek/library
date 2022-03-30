<?php

if(isset($_POST["submit1"])) {

   $newFirstName = htmlspecialchars($_POST["firstName"]);
   $newKeyName = htmlspecialchars($_POST["keyName"]);
   $newMail = htmlspecialchars($_POST["mail"]);
   $newPassword = htmlspecialchars($_POST["password"]);
   $newRole = htmlspecialchars($_POST["role"]);
   $oldMail = htmlspecialchars($_GET["mail"]);

   include "./classes/dbh.classes.php";
   include "./classes/updateUser.classes.php";
   include "./classes/updateUser-contr.classes.php";

   $updateUser = new UpdateUserContr($newFirstName, $newKeyName, $newMail, $newPassword, $newRole, $oldMail);

   $updateUser->updateUser();
}
?>