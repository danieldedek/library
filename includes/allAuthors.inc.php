<?php

include "./classes/dbh.classes.php";
include "./classes/allAuthors.classes.php";
include "./classes/allAuthors-contr.classes.php";

$showAllAuthors = new AllAuthorsContr();

$showAllAuthors->showAllAuthors();
?>