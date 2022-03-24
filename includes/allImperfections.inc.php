<?php

include "./classes/dbh.classes.php";
include "./classes/allImperfections.classes.php";
include "./classes/allImperfections-contr.classes.php";

$showAllImperfections = new AllImperfectionsContr();

$showAllImperfections->showAllImperfections();
?>