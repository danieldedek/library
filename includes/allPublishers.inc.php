<?php

include "./classes/dbh.classes.php";
include "./classes/allPublishers.classes.php";
include "./classes/allPublishers-contr.classes.php";

$showAllPublishers = new AllPublishersContr();

$showAllPublishers->showAllPublishers();
?>