<?php

if(isset($_POST['UDC'])) {
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allUDCsSearch.classes.php";
    include "../classes/allUDCsSearch-contr.classes.php";

    $showAllUDCs = new AllUDCsSearchContr($UDC);

    $showAllUDCs->showAllUDCs();
}
?>