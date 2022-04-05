<?php

include "./classes/dbh.classes.php";
include "./classes/allPublicationPlaces.classes.php";
include "./classes/allPublicationPlaces-contr.classes.php";

$showAllPublicationPlaces = new AllPublicationPlacesContr();

$showAllPublicationPlaces->showAllPublicationPlaces();
?>