<?php

if((isset($_POST["submit"])) && (isset($_GET["UDC"]))) {

   $newUDC = htmlspecialchars($_POST["UDC"]);
   $oldUDC = htmlspecialchars($_GET['UDC']);

   include "./classes/dbh.classes.php";
   include "./classes/updateUDC.classes.php";
   include "./classes/updateUDC-contr.classes.php";

   $updateUDC = new UpdateUDCContr($newUDC, $oldUDC);

   $updateUDC->updateUDC();
}
?>