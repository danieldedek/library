<?php

$idUser = unserialize($_SESSION['user'])->getIdUser();

include "./classes/dbh.classes.php";
include "./classes/userInfo.classes.php";
include "./classes/userInfo-contr.classes.php";

$showBorrowedBooks = new UserInfoContr($idUser);

$showBorrowedBooks->showBorrowedBooks();
?>