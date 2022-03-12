<?php

if(isset($_POST["submit"])) {

   $namesBeforeKey = htmlspecialchars($_POST["namesBeforeKey"]);
   $prefixToKey = htmlspecialchars($_POST["prefixToKey"]);
   $keyName = htmlspecialchars($_POST["keyName"]);
   $namesAfterKey = htmlspecialchars($_POST["namesAfterKey"]);
   $suffixToKey = htmlspecialchars($_POST["suffixToKey"]);

   include "./classes/dbh.classes.php";
   include "./classes/addAuthor.classes.php";
   include "./classes/addAuthor-contr.classes.php";

   $addAuthor = new AddAuthorContr($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey);

   $addAuthor->addAuthor();
}
?>