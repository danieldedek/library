<?php

if(isset($_POST["submit"])) {

   $newPublisher = htmlspecialchars($_POST["publisher"]);
   $oldPublisher = htmlspecialchars($_GET['publisherName']);

   include "./classes/dbh.classes.php";
   include "./classes/updatePublisher.classes.php";
   include "./classes/updatePublisher-contr.classes.php";

   $updatePublisher = new UpdatePublisherContr($newPublisher, $oldPublisher);

   $updatePublisher->updatePublisher();
}
?>