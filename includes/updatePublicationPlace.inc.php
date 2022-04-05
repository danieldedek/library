<?php

if((isset($_POST["submit"])) && (isset($_GET["publicationPlace"]))) {

   $newPublicationPlace = htmlspecialchars($_POST["publicationPlace"]);
   $oldPublicationPlace = htmlspecialchars($_GET['publicationPlace']);

   include "./classes/dbh.classes.php";
   include "./classes/updatePublicationPlace.classes.php";
   include "./classes/updatePublicationPlace-contr.classes.php";

   $updatePublicationPlace = new UpdatePublicationPlaceContr($newPublicationPlace, $oldPublicationPlace);

   $updatePublicationPlace->updatePublicationPlace();
}
?>