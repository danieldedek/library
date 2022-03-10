<?php

if(isset($_POST["submit"])) {

   $firstName = htmlspecialchars($_POST["firstName"]);
   $keyName = htmlspecialchars($_POST["keyName"]);
   $mail = htmlspecialchars($_POST["mail"]);
   $password = htmlspecialchars($_POST["password"]);
   $passwordVerification = htmlspecialchars($_POST["passwordVerification"]);

   include "./classes/dbh.classes.php";
   include "./classes/signUp.classes.php";
   include "./classes/signUp-contr.classes.php";

   $signUp = new SignUpContr($firstName, $keyName, $mail, $password, $passwordVerification);

   $signUp->signUpUser();
}
?>