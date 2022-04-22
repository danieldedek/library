<?php

if(isset($_GET['order']))
    $order = htmlspecialchars($_GET['order']);

else
    $order = 'last_name';

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';

include "./classes/dbh.classes.php";
include "./classes/allUsers.classes.php";
include "./classes/allUsers-contr.classes.php";

$showAllUsers = new AllUsersContr($order, $sort);

$showAllUsers->showAllUsers();
?>