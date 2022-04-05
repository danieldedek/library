<?php

if(isset($_POST["submit"])) {

   $firstName = htmlspecialchars($_POST["firstName"]);
   $lastName = htmlspecialchars($_POST["lastName"]);
   $mail = htmlspecialchars($_POST["mail"]);
   $password = htmlspecialchars($_POST["password"]);
   $passwordVerification = htmlspecialchars($_POST["passwordVerification"]);

   include "./classes/dbh.classes.php";
   include "./classes/signUp.classes.php";
   include "./classes/signUp-contr.classes.php";

   $signUp = new SignUpContr($firstName, $lastName, $mail, $password, $passwordVerification);

   $signUp->signUpUser();
}
?>