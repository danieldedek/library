<?php

include "./classes/dbh.classes.php";
include "./classes/allUDCs.classes.php";
include "./classes/allUDCs-contr.classes.php";

$showAllUDCs = new AllUDCsContr();

$showAllUDCs->showAllUDCs();
?>