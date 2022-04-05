<?php

if((isset($_POST["submit"])) && (isset($_GET["signature"]))) {

   $newSignature = htmlspecialchars($_POST["signature"]);
   $oldSignature = htmlspecialchars($_GET['signature']);

   include "./classes/dbh.classes.php";
   include "./classes/updateSignature.classes.php";
   include "./classes/updateSignature-contr.classes.php";

   $updateSignature = new UpdateSignatureContr($newSignature, $oldSignature);

   $updateSignature->updateSignature();
}
?>