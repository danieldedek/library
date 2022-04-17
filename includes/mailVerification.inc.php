<?php

if(isset($_POST["submit"])) {

   $verificationCode = htmlspecialchars($_POST["verificationCode"]);
   $mail = htmlspecialchars($_GET["mail"]);

   include "./classes/dbh.classes.php";
   include "./classes/mailVerification.classes.php";
   include "./classes/mailVerification-contr.classes.php";

   $mailVerification = new MailVerificationContr($verificationCode, $mail);

   $mailVerification->mailVerification();
}
?>