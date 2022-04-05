<?php

class AddBook extends DatabaseHandler {

    protected function checkIncrementalNumber($incrementalNumber) {
        $stmt = $this->connect()->prepare('SELECT copy.incremental_number FROM copy WHERE copy.incremental_number = ?;');
        if(!$stmt->execute(array($incrementalNumber))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function checkIssueNumber($issueNumber) {
        $stmt = $this->connect()->prepare('SELECT copy.issue_number FROM copy WHERE copy.issue_number = ?;');
        if(!$stmt->execute(array($issueNumber))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function checkISBN($ISBN) {
        $stmt = $this->connect()->prepare('SELECT copy.ISBN FROM copy WHERE copy.ISBN = ?;');
        if(!$stmt->execute(array($ISBN))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setBook($authorNames, $book, $incrementalNumber, $acquisitionDate, $price, $purchaseDocument, $seller, $publicationYear, $publicationPlace, $publisher, $issueNumber, $pageCount, $UDC, $signature, $ISBN, $imperfections) {
        $idAuthors = array();
        $idImperfections = array();

        foreach ($authorNames as $authorName) {
            $stmt = $this->connect()->prepare('SELECT id_author FROM author WHERE name = ?;');

            if(!$stmt->execute(array($authorName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() > 0) {
                $dbAuthor = $stmt->fetchAll(PDO::FETCH_ASSOC);
                array_push($idAuthors, $dbAuthor[0]["id_author"]);
            }

            else {
                $stmt = $this->connect()->prepare('INSERT INTO author(name) VALUES(?);');
        
                if(!$stmt->execute(array($authorName))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }

                $stmt = $this->connect()->prepare('SELECT id_author FROM author WHERE name = ?;');

                if(!$stmt->execute(array($authorName))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }

                $dbAuthor = $stmt->fetchAll(PDO::FETCH_ASSOC);
                array_push($idAuthors, $dbAuthor[0]["id_author"]);

                $stmt = null;
            }
        }

        $stmt = $this->connect()->prepare('SELECT id_book FROM book WHERE name = ?;');

        if(!$stmt->execute(array($book))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbBook = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idBook = $dbBook[0]["id_book"];
        }

        else {
            $stmt = $this->connect()->prepare('INSERT INTO book(name) VALUES(?);');

            if(!$stmt->execute(array($book))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_book FROM book WHERE name = ?;');

            if(!$stmt->execute(array($book))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() > 0) {
                $dbBook = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $idBook = $dbBook[0]["id_book"];
            }
        }

        $stmt = $this->connect()->prepare('SELECT id_publisher FROM publisher WHERE name = ?;');

        if(!$stmt->execute(array($publisher))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbPublisher = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublisher = $dbPublisher[0]["id_publisher"];
        }

        else {
            $stmt = $this->connect()->prepare('INSERT INTO publisher(name) VALUES(?);');

            if(!$stmt->execute(array($publisher))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_publisher FROM publisher WHERE name = ?;');

            if(!$stmt->execute(array($publisher))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbPublisher = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublisher = $dbPublisher[0]["id_publisher"];
            
            $stmt = null;
        }

        $stmt = $this->connect()->prepare('SELECT id_seller FROM seller WHERE name = ?;');

        if(!$stmt->execute(array($seller))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbSeller = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idSeller = $dbSeller[0]["id_seller"];
        }

        else {
            $stmt = $this->connect()->prepare('INSERT INTO seller(name) VALUES(?);');

            if(!$stmt->execute(array($seller))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_seller FROM seller WHERE name = ?;');

            if(!$stmt->execute(array($seller))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbSeller = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idSeller = $dbSeller[0]["id_seller"];
            
            $stmt = null;
        }

        $stmt = $this->connect()->prepare('SELECT id_publication_place FROM publication_place WHERE name = ?;');

        if(!$stmt->execute(array($publicationPlace))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbPublicationPlace = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublicationPlace = $dbPublicationPlace[0]["id_publication_place"];
        }

        else {
            $stmt = $this->connect()->prepare('INSERT INTO publication_place(name) VALUES(?);');

            if(!$stmt->execute(array($publicationPlace))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_publication_place FROM publication_place WHERE name = ?;');

            if(!$stmt->execute(array($publicationPlace))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbPublicationPlace = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublicationPlace = $dbPublicationPlace[0]["id_publication_place"];
            
            $stmt = null;
        }

        $stmt = $this->connect()->prepare('SELECT id_signature FROM signature WHERE name = ?;');

        if(!$stmt->execute(array($signature))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbSignature = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idSignature = $dbSignature[0]["id_signature"];
        }

        else {
            $stmt = $this->connect()->prepare('INSERT INTO signature(name) VALUES(?);');

            if(!$stmt->execute(array($signature))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_signature FROM signature WHERE name = ?;');

            if(!$stmt->execute(array($signature))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbSignature = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idSignature = $dbSignature[0]["id_signature"];
            
            $stmt = null;
        }

        $stmt = $this->connect()->prepare('SELECT id_UDC FROM udc WHERE name = ?;');

        if(!$stmt->execute(array($UDC))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbUDC = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idUDC = $dbUDC[0]["id_UDC"];
        }

        else {
            $stmt = $this->connect()->prepare('INSERT INTO udc(name) VALUES(?);');

            if(!$stmt->execute(array($UDC))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_UDC FROM udc WHERE name = ?;');

            if(!$stmt->execute(array($UDC))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbUDC = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idUDC = $dbUDC[0]["id_UDC"];
            
            $stmt = null;
        }

        foreach ($imperfections as $imperfection) {
            if($imperfection != "NULL") {
                $stmt = $this->connect()->prepare('SELECT id_imperfection FROM imperfection WHERE name = ?;');

                if(!$stmt->execute(array($imperfection))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }

                if($stmt->rowCount() > 0) {
                    $dbImperfection = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    array_push($idImperfections, $dbImperfection[0]["id_imperfection"]);
                }

                else {
                    $stmt = $this->connect()->prepare('INSERT INTO imperfection(name) VALUES(?);');

                    if(!$stmt->execute(array($imperfection))) {
                        $stmt = null;
                        echo '<div class="wrapper"><p>stmt failed</p></div>';
                        exit();
                    }

                    $stmt = $this->connect()->prepare('SELECT id_imperfection FROM imperfection WHERE name = ?;');

                    if(!$stmt->execute(array($imperfection))) {
                        $stmt = null;
                        echo '<div class="wrapper"><p>stmt failed</p></div>';
                        exit();
                    }

                    $dbImperfection = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    array_push($idImperfections, $dbImperfection[0]["id_imperfection"]);
                    
                    $stmt = null;
                }
            }
        }

        foreach ($idAuthors as $idAuthor) {
            $stmt = $this->connect()->prepare('SELECT book_id_book, author_id_author FROM book_has_author WHERE book_id_book = ? AND author_id_author = ?;');

            if(!$stmt->execute(array($idBook, $idAuthor))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if(!$stmt->rowCount() > 0) {
                $stmt = $this->connect()->prepare('INSERT INTO book_has_author(book_id_book, author_id_author) VALUES(?, ?);');

                if(!$stmt->execute(array($idBook, $idAuthor))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }

        if($acquisitionDate == "NULL") {
            $stmt = $this->connect()->prepare('INSERT INTO copy(book_id_book, incremental_number, acquisition_date, price, purchase_document, seller_id_seller, publication_year, publication_place_id_publication_place, publisher_id_publisher, issue_number, page_count, UDC_id_UDC, signature_id_signature, ISBN) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');

            if(!$stmt->execute(array($idBook, $incrementalNumber, date("Y-m-d"), $price, $purchaseDocument, $idSeller, $publicationYear, $idPublicationPlace, $idPublisher, $issueNumber, $pageCount, $idUDC, $idSignature, $ISBN))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else {
            $stmt = $this->connect()->prepare('INSERT INTO copy(book_id_book, incremental_number, acquisition_date, price, purchase_document, seller_id_seller, publication_year, publication_place_id_publication_place, publisher_id_publisher, issue_number, page_count, UDC_id_UDC, signature_id_signature, ISBN) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');

            if(!$stmt->execute(array($idBook, $incrementalNumber, $acquisitionDate, $price, $purchaseDocument, $idSeller, $publicationYear, $idPublicationPlace, $idPublisher, $issueNumber, $pageCount, $idUDC, $idSignature, $ISBN))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        for ($i = 0; $i < count($imperfections); $i++) {
            if($imperfections[$i] != "NULL") {
                $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE ISBN = ?;');

                if(!$stmt->execute(array($ISBN))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }

                $dbCopy = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $idCopy = $dbCopy[0]["id_copy"];

                $stmt = $this->connect()->prepare('INSERT INTO to_repair(copy_id_copy, imperfection_id_imperfection, damaged_date) VALUES(?, ?, ?);');

                if(!$stmt->execute(array($idCopy, $idImperfections[$i], date("Y-m-d")))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }
        
        $stmt = null;
    }
}
?>