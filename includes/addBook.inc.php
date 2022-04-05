<?php

if(isset($_POST["submit"])) {

   $authorNames = array();
   foreach ($_POST['authorName'] as $authorName) {
      array_push($authorNames, htmlspecialchars($authorName));
   }
   $book = htmlspecialchars($_POST["book"]);
   $incrementalNumber = htmlspecialchars($_POST["incrementalNumber"]);
   $acquisitionDate = htmlspecialchars($_POST["acquisitionDate"]);
   $price = htmlspecialchars($_POST["price"]);
   $purchaseDocument = htmlspecialchars($_POST["purchaseDocument"]);
   $seller = htmlspecialchars($_POST["seller"]);
   $publicationYear = htmlspecialchars($_POST["publicationYear"]);
   $publicationPlace = htmlspecialchars($_POST["publicationPlace"]);
   $publisher = htmlspecialchars($_POST["publisher"]);
   $issueNumber = htmlspecialchars($_POST["issueNumber"]);
   $pageCount = htmlspecialchars($_POST["pageCount"]);
   $UDC = htmlspecialchars($_POST["UDC"]);
   $signature = htmlspecialchars($_POST["signature"]);
   $ISBN = htmlspecialchars($_POST["ISBN"]);
   $imperfections = array();
   if(isset($_POST["imperfection"])) {
      foreach ($_POST['imperfection'] as $imperfection) {
         array_push($imperfections, htmlspecialchars($imperfection));
      }
   }

   include "./classes/addBook.classes.php";
   include "./classes/addBook-contr.classes.php";

   $addBook = new AddBookContr($authorNames, $book, $incrementalNumber, $acquisitionDate, $price, $purchaseDocument, $seller, $publicationYear, $publicationPlace, $publisher, $issueNumber, $pageCount, $UDC, $signature, $ISBN, $imperfections);

   $addBook->addBook();
}
?>