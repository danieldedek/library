<?php

if(isset($_POST['publicationPlace'])) {
    $publicationPlace = htmlspecialchars($_POST['publicationPlace']);

    include "../classes/dbh.classes.php";
    include "../classes/allPublicationPlacesSearch.classes.php";
    include "../classes/allPublicationPlacesSearch-contr.classes.php";

    $showAllPublicationPlaces = new AllPublicationPlacesSearchContr($publicationPlace);

    $showAllPublicationPlaces->showAllPublicationPlaces();
}
?>