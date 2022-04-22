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
include "./classes/allBooks.classes.php";
include "./classes/allBooks-contr.classes.php";

$showAllBooks = new AllBooksContr($order, $sort);

$showAllBooks->showAllBooks();
?>