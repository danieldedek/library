<?php

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';
    
include "./classes/dbh.classes.php";
include "./classes/allPublishers.classes.php";
include "./classes/allPublishers-contr.classes.php";

$showAllPublishers = new AllPublishersContr($sort);

$showAllPublishers->showAllPublishers();
?>