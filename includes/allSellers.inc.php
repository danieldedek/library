<?php

include "./classes/dbh.classes.php";
include "./classes/allSellers.classes.php";
include "./classes/allSellers-contr.classes.php";

$showAllSellers = new AllSellersContr();

$showAllSellers->showAllSellers();
?>