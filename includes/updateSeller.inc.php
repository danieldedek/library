<?php

if((isset($_POST["submit"])) && (isset($_GET["seller"]))) {

   $newSeller = htmlspecialchars($_POST["seller"]);
   $oldSeller = htmlspecialchars($_GET['seller']);

   include "./classes/dbh.classes.php";
   include "./classes/updateSeller.classes.php";
   include "./classes/updateSeller-contr.classes.php";

   $updateSeller = new UpdateSellerContr($newSeller, $oldSeller);

   $updateSeller->updateSeller();
}
?>