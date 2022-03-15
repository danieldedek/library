<?php

if(isset($_POST["submit"])) {

   $imperfection = htmlspecialchars($_POST["imperfection"]);

   include "./classes/dbh.classes.php";
   include "./classes/addImperfection.classes.php";
   include "./classes/addImperfection-contr.classes.php";

   $addImperfection = new AddImperfectionContr($imperfection);

   $addImperfection->addImperfection();
}
?>