<?php
if(isset($_POST['submit'])) {
    $fileName = $_FILES['fileToUpload']['tmp_name'];

    if($_FILES['fileToUpload']['size'] > 0) {
        $file = fopen($fileName, "r");

        include "./classes/dbh.classes.php";
        include "./classes/addBook.classes.php";
        include "./classes/addBook-contr.classes.php";

        $count = 0;
        while(($line = fgetcsv($file, 10000, ";")) !== FALSE) {
            $count++;
            if ($count == 1)
                continue;
            $authorNames = array();
            array_push($authorNames, htmlspecialchars($line[0]));
            $book = $line[1];
            $incrementalNumber = $line[2];
            $acquisitionDate = date("Y-m-d", strtotime($line[3]));
            $price = htmlspecialchars($line[4]);
            $purchaseDocument = htmlspecialchars($line[5]);
            $seller = htmlspecialchars($line[6]);
            $publicationYear = htmlspecialchars($line[7]);
            $publicationPlace = htmlspecialchars($line[8]);
            $publisher = htmlspecialchars($line[9]);
            $issueNumber = htmlspecialchars($line[10]);
            $pageCount = htmlspecialchars($line[11]);
            $UDC = htmlspecialchars($line[12]);
            $signature = htmlspecialchars($line[13]);
            $ISBN = htmlspecialchars($line[14]);
            $imperfections = array();
            if(isset($line[15])) {
                array_push($imperfections, htmlspecialchars($line[15]));
            }

            $addBook = new AddBookContr($authorNames, $book, $incrementalNumber, $acquisitionDate, $price, $purchaseDocument, $seller, $publicationYear, $publicationPlace, $publisher, $issueNumber, $pageCount, $UDC, $signature, $ISBN, $imperfections);

            $addBook->addBook();
        }

        fclose($file);
    }
}
?>