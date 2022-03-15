<?php

if(isset($_POST["submit"])) {

   $namesBeforeKey = htmlspecialchars($_POST["namesBeforeKey"]);
   $prefixToKey = htmlspecialchars($_POST["prefixToKey"]);
   $keyName = htmlspecialchars($_POST["keyName"]);
   $namesAfterKey = htmlspecialchars($_POST["namesAfterKey"]);
   $suffixToKey = htmlspecialchars($_POST["suffixToKey"]);
   $bookName = htmlspecialchars($_POST["bookName"]);
   $publicationDate = htmlspecialchars($_POST["publicationDate"]);
   $ISBN = htmlspecialchars($_POST["ISBN"]);
   $imperfection = htmlspecialchars($_POST["imperfection"]);
   $publisherName = htmlspecialchars($_POST["publisherName"]);

   include "./classes/dbh.classes.php";
   include "./classes/addAuthor.classes.php";
   include "./classes/addBook.classes.php";
   include "./classes/addBook-contr.classes.php";

   $addBook = new AddBookContr($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName);

   $addBook->addBook();
}
?>