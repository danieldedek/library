<?php

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';

include "./classes/dbh.classes.php";
include "./classes/allSignatures.classes.php";
include "./classes/allSignatures-contr.classes.php";

$showAllSignatures = new AllSignaturesContr($sort);

$showAllSignatures->showAllSignatures();
?>