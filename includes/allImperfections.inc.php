<?php

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';

include "./classes/dbh.classes.php";
include "./classes/allImperfections.classes.php";
include "./classes/allImperfections-contr.classes.php";

$showAllImperfections = new AllImperfectionsContr($sort);

$showAllImperfections->showAllImperfections();
?>