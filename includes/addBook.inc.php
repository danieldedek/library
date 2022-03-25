<?php

if(isset($_POST["submit"])) {

   $authorName = htmlspecialchars($_POST["authorName"]);
   $bookName = htmlspecialchars($_POST["bookName"]);
   $publicationYear = htmlspecialchars($_POST["publicationYear"]);
   $ISBN = htmlspecialchars($_POST["ISBN"]);
   $registrationNumber = htmlspecialchars($_POST["registrationNumber"]);
   $imperfection = htmlspecialchars($_POST["imperfection"]);
   $publisherName = htmlspecialchars($_POST["publisherName"]);

   include "./classes/dbh.classes.php";
   include "./classes/addAuthor.classes.php";
   include "./classes/addBook.classes.php";
   include "./classes/addBook-contr.classes.php";

   $addBook = new AddBookContr($authorName, $bookName, $publicationYear, $ISBN, $registrationNumber, $imperfection, $publisherName);

   $addBook->addBook();
}
?>