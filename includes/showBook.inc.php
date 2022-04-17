<?php

$ISBN = $_GET["ISBN"];

include "./classes/dbh.classes.php";
include "./classes/showBook.classes.php";
include "./classes/showBook-contr.classes.php";

$showBook = new ShowBookContr($ISBN);

$showBook->showBook();
?>