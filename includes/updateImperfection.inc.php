<?php

if((isset($_POST["submit"])) && (isset($_GET["imperfectionName"]))) {

   $newImperfection = htmlspecialchars($_POST["imperfection"]);
   $oldimperfection = htmlspecialchars($_GET['imperfectionName']);

   include "./classes/dbh.classes.php";
   include "./classes/updateImperfection.classes.php";
   include "./classes/updateImperfection-contr.classes.php";

   $updateImperfection = new UpdateImperfectionContr($newImperfection, $oldimperfection);

   $updateImperfection->updateImperfection();
}
?>