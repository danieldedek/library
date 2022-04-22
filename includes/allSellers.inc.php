<?php

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';

include "./classes/dbh.classes.php";
include "./classes/allSellers.classes.php";
include "./classes/allSellers-contr.classes.php";

$showAllSellers = new AllSellersContr($sort);

$showAllSellers->showAllSellers();
?>