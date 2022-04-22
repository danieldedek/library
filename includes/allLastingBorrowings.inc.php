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
include "./classes/allLastingBorrowings.classes.php";
include "./classes/allLastingBorrowings-contr.classes.php";

$showAllLastingBorrowings = new AllLastingBorrowingsContr($order, $sort);

$showAllLastingBorrowings->showAllLastingBorrowings();
?>