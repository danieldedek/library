<?php

if(isset($_GET['order']))
    $order = htmlspecialchars($_GET['order']);

else
    $order = 'incremental_number';

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';

include "./classes/dbh.classes.php";
include "./classes/allBorrowings.classes.php";
include "./classes/allBorrowings-contr.classes.php";

$showAllBorrowings = new AllBorrowingsContr($order, $sort);

$showAllBorrowings->showAllBorrowings();
?>