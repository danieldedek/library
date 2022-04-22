<?php

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';

include "./classes/dbh.classes.php";
include "./classes/allAuthors.classes.php";
include "./classes/allAuthors-contr.classes.php";

$showAllAuthors = new AllAuthorsContr($sort);

$showAllAuthors->showAllAuthors();
?>