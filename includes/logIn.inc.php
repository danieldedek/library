<?php

if(isset($_POST["submit"])) {

   $mail = htmlspecialchars($_POST["mail"]);
   $password = htmlspecialchars($_POST["password"]);

   include "./classes/dbh.classes.php";
   include "./classes/logIn.classes.php";
   include "./classes/logIn-contr.classes.php";

   $logIn = new LogInContr($mail, $password);

   $logIn->logInUser();
}
?>