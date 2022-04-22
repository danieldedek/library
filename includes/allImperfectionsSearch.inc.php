<?php

if(isset($_POST['imperfection'])) {
    $imperfection = htmlspecialchars($_POST['imperfection']);

    include "../classes/dbh.classes.php";
    include "../classes/allImperfectionsSearch.classes.php";
    include "../classes/allImperfectionsSearch-contr.classes.php";

    $showAllImperfections = new AllImperfectionsSearchContr($imperfection);

    $showAllImperfections->showAllImperfections();
}
?>