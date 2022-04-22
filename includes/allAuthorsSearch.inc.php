<?php

if(isset($_POST['authorName'])) {
    $authorName = htmlspecialchars($_POST['authorName']);

    include "../classes/dbh.classes.php";
    include "../classes/allAuthorsSearch.classes.php";
    include "../classes/allAuthorsSearch-contr.classes.php";

    $showAllAuthors = new AllAuthorsSearchContr($authorName);

    $showAllAuthors->showAllAuthors();
}
?>