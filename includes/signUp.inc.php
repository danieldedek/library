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
   include "./mail1.php";

   $verificationCode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

   $signUp = new SignUpContr($firstName, $lastName, $mail, $password, $passwordVerification, $verificationCode);

   $signUp->signUpUser();

   $url = "http://localhost/mailVerification.php?mail=" . $mail;

   $subject = 'Ověření mailu do školní knihovny';

   $msg = '<p>Ověřovací kód: ' . $verificationCode . ' Odkaz: <br /></p>';
   $msg .= '<a href="' . $url . '">' . $url . '</a></p>';

   smtp_mailer($mail, $subject, $msg);

   header("Location: ./mailVerification.php?mail=" . $mail);
}
?>