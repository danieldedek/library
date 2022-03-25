<?php

if(isset($_POST["submit"])) {

   $name = htmlspecialchars($_POST["name"]);

   include "./classes/dbh.classes.php";
   include "./classes/addAuthor.classes.php";
   include "./classes/addAuthor-contr.classes.php";

   $addAuthor = new AddAuthorContr($name);

   $addAuthor->addAuthor();
}
?>