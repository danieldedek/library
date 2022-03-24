<?php

include "./classes/dbh.classes.php";
include "./classes/allUsers.classes.php";
include "./classes/allUsers-contr.classes.php";

$showAllUsers = new AllUsersContr();

$showAllUsers->showAllUsers();
?>