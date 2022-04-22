<?php

if(isset($_POST['publisher'])) {
    $publisher = htmlspecialchars($_POST['publisher']);

    include "../classes/dbh.classes.php";
    include "../classes/allPublishersSearch.classes.php";
    include "../classes/allPublishersSearch-contr.classes.php";

    $showAllPublishers = new AllPublishersSearchContr($publisher);

    $showAllPublishers->showAllPublishers();
}
?>