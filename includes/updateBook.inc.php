<?php

if((isset($_POST["submit1"])) && (isset($_GET["ISBN"]))) {

   $newAuthorNames = array();
   foreach ($_POST['authorName'] as $authorName) {
      array_push($newAuthorNames, htmlspecialchars($authorName));
   }
   $newBook = htmlspecialchars($_POST["book"]);
   $newIncrementalNumber = htmlspecialchars($_POST["incrementalNumber"]);
   $newAcquisitionDate = htmlspecialchars($_POST["acquisitionDate"]);
   $newPrice = htmlspecialchars($_POST["price"]);
   $newPurchaseDocument = htmlspecialchars($_POST["purchaseDocument"]);
   $newSeller = htmlspecialchars($_POST["seller"]);
   $newPublicationYear = htmlspecialchars($_POST["publicationYear"]);
   $newPublicationPlace = htmlspecialchars($_POST["publicationPlace"]);
   $newPublisher = htmlspecialchars($_POST["publisher"]);
   $newIssueNumber = htmlspecialchars($_POST["issueNumber"]);
   $newPageCount = htmlspecialchars($_POST["pageCount"]);
   $newUDC = htmlspecialchars($_POST["UDC"]);
   $newSignature = htmlspecialchars($_POST["signature"]);
   $newISBN = htmlspecialchars($_POST["ISBN"]);
   $newImperfections = array();
   if(isset($_POST["imperfection"])) {
      foreach ($_POST['imperfection'] as $imperfection) {
         array_push($newImperfections, htmlspecialchars($imperfection));
      }
   }

   $oldBook = htmlspecialchars($_GET["book"]);
   $oldSeller = htmlspecialchars($_GET["seller"]);
   $oldPublicationPlace = htmlspecialchars($_GET["publicationPlace"]);
   $oldPublisher = htmlspecialchars($_GET["publisher"]);
   $oldUDC = htmlspecialchars($_GET["UDC"]);
   $oldSignature = htmlspecialchars($_GET["signature"]);
   $oldIncrementalNumber = htmlspecialchars($_GET["incrementalNumber"]);
   $oldIssueNumber = htmlspecialchars($_GET["issueNumber"]);
   $oldISBN = htmlspecialchars($_GET['ISBN']);

   include "./classes/updateBook.classes.php";
   include "./classes/updateBook-contr.classes.php";

   $updateBook = new UpdateBookContr($newAuthorNames, $newBook, $newIncrementalNumber, $newAcquisitionDate, $newPrice, $newPurchaseDocument, $newSeller, $newPublicationYear, $newPublicationPlace, $newPublisher, $newIssueNumber, $newPageCount, $newUDC, $newSignature, $newISBN, $newImperfections, $oldBook, $oldSeller, $oldPublicationPlace, $oldPublisher, $oldUDC, $oldSignature, $oldIncrementalNumber, $oldIssueNumber, $oldISBN, $authors, $imperfections);

   $updateBook->updateBook();
}
?>