<?php

class UpdateBook extends DatabaseHandler {

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

    protected function setBook($newAuthorNames, $newBook, $newIncrementalNumber, $newAcquisitionDate, $newPrice, $newPurchaseDocument, $newSeller, $newPublicationYear, $newPublicationPlace, $newPublisher, $newIssueNumber, $newPageCount, $newUDC, $newSignature, $newISBN, $newImperfections, $oldBook, $oldSeller, $oldPublicationPlace, $oldPublisher, $oldUDC, $oldSignature, $oldISBN, $authors, $imperfections) {
        $idAuthors = array();
        $idImperfections = array();

        foreach ($newAuthorNames as $authorName) {
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
            }
        }

        $stmt = $this->connect()->prepare('SELECT id_book FROM book WHERE name = ?;');

        if(!$stmt->execute(array($newBook))) {
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

            if(!$stmt->execute(array($newBook))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_book FROM book WHERE name = ?;');

            if(!$stmt->execute(array($newBook))) {
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

        if(!$stmt->execute(array($newPublisher))) {
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

            if(!$stmt->execute(array($newPublisher))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_publisher FROM publisher WHERE name = ?;');

            if(!$stmt->execute(array($newPublisher))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbPublisher = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublisher = $dbPublisher[0]["id_publisher"];
            
            $stmt = null;
        }

        $stmt = $this->connect()->prepare('SELECT id_seller FROM seller WHERE name = ?;');

        if(!$stmt->execute(array($newSeller))) {
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

            if(!$stmt->execute(array($newSeller))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_seller FROM seller WHERE name = ?;');

            if(!$stmt->execute(array($newSeller))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbSeller = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idSeller = $dbSeller[0]["id_seller"];
            
            $stmt = null;
        }

        $stmt = $this->connect()->prepare('SELECT id_publication_place FROM publication_place WHERE name = ?;');

        if(!$stmt->execute(array($newPublicationPlace))) {
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

            if(!$stmt->execute(array($newPublicationPlace))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_publication_place FROM publication_place WHERE name = ?;');

            if(!$stmt->execute(array($newPublicationPlace))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbPublicationPlace = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublicationPlace = $dbPublicationPlace[0]["id_publication_place"];
            
            $stmt = null;
        }

        $stmt = $this->connect()->prepare('SELECT id_signature FROM signature WHERE name = ?;');

        if(!$stmt->execute(array($newSignature))) {
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

            if(!$stmt->execute(array($newSignature))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_signature FROM signature WHERE name = ?;');

            if(!$stmt->execute(array($newSignature))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbSignature = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idSignature = $dbSignature[0]["id_signature"];
            
            $stmt = null;
        }

        $stmt = $this->connect()->prepare('SELECT id_UDC FROM udc WHERE name = ?;');

        if(!$stmt->execute(array($newUDC))) {
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

            if(!$stmt->execute(array($newUDC))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_UDC FROM udc WHERE name = ?;');

            if(!$stmt->execute(array($newUDC))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbUDC = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idUDC = $dbUDC[0]["id_UDC"];
            
            $stmt = null;
        }

        foreach ($newImperfections as $imperfection) {
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

        if($newAcquisitionDate == "NULL") {
            $stmt = $this->connect()->prepare('UPDATE copy SET book_id_book = ?, incremental_number = ?, acquisition_date = ?, price = ?, purchase_document = ?, seller_id_seller = ?, publication_year = ?, publication_place_id_publication_place = ?, publisher_id_publisher = ?, issue_number = ?, page_count = ?, UDC_id_UDC = ?, signature_id_signature = ?, ISBN = ? WHERE ISBN = ?;');

            if(!$stmt->execute(array($idBook, $newIncrementalNumber, date("Y-m-d"), $newPrice, $newPurchaseDocument, $idSeller, $newPublicationYear, $idPublicationPlace, $idPublisher, $newIssueNumber, $newPageCount, $idUDC, $idSignature, $newISBN, $oldISBN))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else {
            $stmt = $this->connect()->prepare('UPDATE copy SET book_id_book = ?, incremental_number = ?, acquisition_date = ?, price = ?, purchase_document = ?, seller_id_seller = ?, publication_year = ?, publication_place_id_publication_place = ?, publisher_id_publisher = ?, issue_number = ?, page_count = ?, UDC_id_UDC = ?, signature_id_signature = ?, ISBN = ? WHERE ISBN = ?;');

            if(!$stmt->execute(array($idBook, $newIncrementalNumber, $newAcquisitionDate, $newPrice, $newPurchaseDocument, $idSeller, $newPublicationYear, $idPublicationPlace, $idPublisher, $newIssueNumber, $newPageCount, $idUDC, $idSignature, $newISBN, $oldISBN))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        for ($i = 0; $i < count($newImperfections); $i++) {
            if($newImperfections[$i] != "NULL") {
                $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE ISBN = ?;');

                if(!$stmt->execute(array($newISBN))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }

                $dbCopy = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $idCopy = $dbCopy[0]["id_copy"];

                $stmt = $this->connect()->prepare('UPDATE to_repair SET copy_id_copy = ?, imperfection_id_imperfection = ?, damaged_date = ?;');

                if(!$stmt->execute(array($idCopy, $idImperfections[$i], date("Y-m-d")))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }


        for ($i = 0; $i < sizeof($authors); $i++) {
            $stmt = $this->connect()->prepare('SELECT id_author FROM author WHERE name = ?;');

            if(!$stmt->execute(array($authors[$i]))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() > 0) {
                $dbAuthor = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $idAuthor = $dbAuthor[0]["id_author"];

                $stmt = $this->connect()->prepare('SELECT book_id_book, author_id_author FROM book_has_author WHERE author_id_author = ?');

                if(!$stmt->execute(array($idAuthor))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }

                if($stmt->rowCount() == 0) {
                    $stmt = $this->connect()->prepare('DELETE FROM author WHERE name = ?;');

                    if(!$stmt->execute(array($authors[$i]))) {
                        $stmt = null;
                        echo '<div class="wrapper"><p>stmt failed</p></div>';
                        exit();
                    }
                }
            }
        }
        
        $stmt = $this->connect()->prepare('SELECT id_book FROM book WHERE name = ?;');

        if(!$stmt->execute(array($oldBook))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbBook = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idBook = $dbBook[0]["id_book"];

            $stmt = $this->connect()->prepare('SELECT book_id_book, author_id_author FROM book_has_author WHERE book_id_book = ?');

            if(!$stmt->execute(array($idBook))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = $this->connect()->prepare('DELETE FROM book WHERE name = ?;');

                if(!$stmt->execute(array($oldBook))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }

        $stmt = $this->connect()->prepare('SELECT id_publisher FROM publisher WHERE name = ?;');

        if(!$stmt->execute(array($oldPublisher))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbPublisher = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublisher = $dbPublisher[0]["id_publisher"];

            $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE publisher_id_publisher = ?');

            if(!$stmt->execute(array($idPublisher))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = $this->connect()->prepare('DELETE FROM publisher WHERE name = ?;');

                if(!$stmt->execute(array($oldPublisher))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }

        $stmt = $this->connect()->prepare('SELECT id_seller FROM seller WHERE name = ?;');

        if(!$stmt->execute(array($oldSeller))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbSeller = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idSeller = $dbSeller[0]["id_seller"];

            $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE seller_id_seller = ?');

            if(!$stmt->execute(array($idSeller))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = $this->connect()->prepare('DELETE FROM seller WHERE name = ?;');

                if(!$stmt->execute(array($oldSeller))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }

        $stmt = $this->connect()->prepare('SELECT id_publication_place FROM publication_place WHERE name = ?;');

        if(!$stmt->execute(array($oldPublicationPlace))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbPublicationPlace = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublicationPlace = $dbPublicationPlace[0]["id_publication_place"];

            $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE publication_place_id_publication_place = ?');

            if(!$stmt->execute(array($idPublicationPlace))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = $this->connect()->prepare('DELETE FROM publication_place WHERE name = ?;');

                if(!$stmt->execute(array($oldPublicationPlace))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }

        $stmt = $this->connect()->prepare('SELECT id_signature FROM signature WHERE name = ?;');

        if(!$stmt->execute(array($oldSignature))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbSignature = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idSignature = $dbSignature[0]["id_signature"];

            $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE signature_id_signature = ?');

            if(!$stmt->execute(array($idSignature))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = $this->connect()->prepare('DELETE FROM signature WHERE name = ?;');

                if(!$stmt->execute(array($oldSignature))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }

        $stmt = $this->connect()->prepare('SELECT id_UDC FROM udc WHERE name = ?;');

        if(!$stmt->execute(array($oldUDC))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbUDC = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idUDC = $dbUDC[0]["id_UDC"];

            $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE UDC_id_UDC = ?');

            if(!$stmt->execute(array($idUDC))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = $this->connect()->prepare('DELETE FROM udc WHERE name = ?;');

                if(!$stmt->execute(array($oldUDC))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
            }
        }

        for ($i = 0; $i < sizeof($imperfections); $i++) {
            if($imperfections[$i] != "NULL") {
                $stmt = $this->connect()->prepare('SELECT id_imperfection FROM imperfection WHERE name = ?;');

                if(!$stmt->execute(array($imperfections[$i]))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }

                if($stmt->rowCount() > 0) {
                    $dbImperfection = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $idImperfection = $dbImperfection[0]["id_imperfection"];

                    $stmt = $this->connect()->prepare('SELECT id_to_repair FROM to_repair WHERE imperfection_id_imperfection = ?');

                    if(!$stmt->execute(array($idImperfection))) {
                        $stmt = null;
                        echo '<div class="wrapper"><p>stmt failed</p></div>';
                        exit();
                    }

                    if($stmt->rowCount() == 0) {
                        $stmt = $this->connect()->prepare('DELETE FROM imperfection WHERE name = ?;');

                        if(!$stmt->execute(array($imperfections[$i]))) {
                            $stmt = null;
                            echo '<div class="wrapper"><p>stmt failed</p></div>';
                            exit();
                        }
                    }
                }
            }
        }
        
        $stmt = null;
    }
}
?>