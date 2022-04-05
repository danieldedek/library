<?php

if((isset($_POST["submit"])) && (isset($_GET["publisher"]))) {

   $newPublisher = htmlspecialchars($_POST["publisher"]);
   $oldPublisher = htmlspecialchars($_GET['publisher']);

   include "./classes/dbh.classes.php";
   include "./classes/updatePublisher.classes.php";
   include "./classes/updatePublisher-contr.classes.php";

   $updatePublisher = new UpdatePublisherContr($newPublisher, $oldPublisher);

   $updatePublisher->updatePublisher();
}
?>