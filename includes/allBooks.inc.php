<?php

include "./classes/dbh.classes.php";
include "./classes/allBooks.classes.php";
include "./classes/allBooks-contr.classes.php";

$showAllBooks = new AllBooksContr();

$showAllBooks->showAllBooks();
?>