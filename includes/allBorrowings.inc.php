<?php

include "./classes/dbh.classes.php";
include "./classes/allBorrowings.classes.php";
include "./classes/allBorrowings-contr.classes.php";

$showAllBorrowings = new AllBorrowingsContr();

$showAllBorrowings->showAllBorrowings();
?>