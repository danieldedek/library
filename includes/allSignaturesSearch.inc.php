<?php

if(isset($_POST['signature'])) {
    $signature = htmlspecialchars($_POST['signature']);

    include "../classes/dbh.classes.php";
    include "../classes/allSignaturesSearch.classes.php";
    include "../classes/allSignaturesSearch-contr.classes.php";

    $showAllSignatures = new AllSignaturesSearchContr($signature);

    $showAllSignatures->showAllSignatures();
}
?>