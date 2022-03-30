<?php

if(isset($_POST["submit"])) {

   $authorNames = array();
   foreach ($_POST['authorName'] as $authorName) {
      array_push($authorNames, htmlspecialchars($authorName));
   }
   $bookName = htmlspecialchars($_POST["bookName"]);
   $publicationYear = htmlspecialchars($_POST["publicationYear"]);
   $ISBN = htmlspecialchars($_POST["ISBN"]);
   $registrationNumber = htmlspecialchars($_POST["registrationNumber"]);
   $imperfections = array();
   if(isset($_POST["imperfection"])) {
      foreach ($_POST['imperfection'] as $imperfection) {
         array_push($imperfections, htmlspecialchars($imperfection));
      }
   }
   $publisherName = htmlspecialchars($_POST["publisherName"]);

   include "./classes/dbh.classes.php";
   include "./classes/addBook.classes.php";
   include "./classes/addBook-contr.classes.php";

   $addBook = new AddBookContr($authorNames, $bookName, $publicationYear, $ISBN, $registrationNumber, $imperfections, $publisherName);

   $addBook->addBook();
}
?>