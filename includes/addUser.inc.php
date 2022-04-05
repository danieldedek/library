<?php

if(isset($_POST["submit"])) {

   $firstName = htmlspecialchars($_POST["firstName"]);
   $lastName = htmlspecialchars($_POST["lastName"]);
   $mail = htmlspecialchars($_POST["mail"]);
   $password = htmlspecialchars($_POST["password"]);
   $role = htmlspecialchars($_POST["role"]);

   include "./classes/dbh.classes.php";
   include "./classes/addUser.classes.php";
   include "./classes/addUser-contr.classes.php";

   $addUser = new AddUserContr($firstName, $lastName, $mail, $password, $role);

   $addUser->addUser();
}
?>