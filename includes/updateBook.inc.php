<?php

if(isset($_POST["submit1"])) {

   $newAuthorNames = array();
   foreach ($_POST['authorName'] as $authorName) {
      array_push($newAuthorNames, htmlspecialchars($authorName));
   }
   $newBookName = htmlspecialchars($_POST["bookName"]);
   $newPublicationYear = htmlspecialchars($_POST["publicationYear"]);
   $newISBN = htmlspecialchars($_POST["ISBN"]);
   $newRegistrationNumber = htmlspecialchars($_POST["registrationNumber"]);
   $newImperfections = array();
   if(isset($_POST["imperfection"])) {
      foreach ($_POST['imperfection'] as $imperfection) {
         array_push($newImperfections, htmlspecialchars($imperfection));
      }
   }
   $newPublisherName = htmlspecialchars($_POST["publisherName"]);
   $oldISBN = htmlspecialchars($_GET["ISBN"]);
   $oldRegistrationNumber = htmlspecialchars($_GET["registrationNumber"]);

   include "./classes/updateBook.classes.php";
   include "./classes/updateBook-contr.classes.php";

   $updateBook = new UpdateBookContr($newAuthorNames, $newBookName, $newPublicationYear, $newISBN, $newRegistrationNumber, $newImperfections, $newPublisherName, $oldISBN, $oldRegistrationNumber);

   $updateBook->updateBook();
}
?>