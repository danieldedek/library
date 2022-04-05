<?php

include "./classes/dbh.classes.php";
include "./classes/allSignatures.classes.php";
include "./classes/allSignatures-contr.classes.php";

$showAllSignatures = new AllSignaturesContr();

$showAllSignatures->showAllSignatures();
?>