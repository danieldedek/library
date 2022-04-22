<?php

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';

include "./classes/dbh.classes.php";
include "./classes/allPublicationPlaces.classes.php";
include "./classes/allPublicationPlaces-contr.classes.php";

$showAllPublicationPlaces = new AllPublicationPlacesContr($sort);

$showAllPublicationPlaces->showAllPublicationPlaces();
?>