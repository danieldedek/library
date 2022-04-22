<?php

if(isset($_GET['sort']))
    $sort = htmlspecialchars($_GET['sort']);

else
    $sort = 'ASC';

include "./classes/dbh.classes.php";
include "./classes/allUDCs.classes.php";
include "./classes/allUDCs-contr.classes.php";

$showAllUDCs = new AllUDCsContr($sort);

$showAllUDCs->showAllUDCs();
?>