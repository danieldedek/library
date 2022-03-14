<?php

if(isset($_POST["submit"])) {

   $publisherName = htmlspecialchars($_POST["publisherName"]);

   include "./classes/dbh.classes.php";
   include "./classes/addPublisher.classes.php";
   include "./classes/addPublisher-contr.classes.php";

   $addPublisher = new AddPublisherContr($publisherName);

   $addPublisher->addPublisher();
}
?>