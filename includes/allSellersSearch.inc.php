<?php

if(isset($_POST['seller'])) {
    $seller = htmlspecialchars($_POST['seller']);

    include "../classes/dbh.classes.php";
    include "../classes/allSellersSearch.classes.php";
    include "../classes/allSellersSearch-contr.classes.php";

    $showAllSellers = new AllSellersSearchContr($seller);

    $showAllSellers->showAllSellers();
}
?>