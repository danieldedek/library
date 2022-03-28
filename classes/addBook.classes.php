<?php

class AddBook extends DatabaseHandler {

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

    protected function checkRegistrationNumber($registrationNumber) {
        $stmt = $this->connect()->prepare('SELECT copy.registration_number FROM copy WHERE copy.registration_number = ?;');
        if(!$stmt->execute(array($registrationNumber))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setBook($authorNames, $bookName, $publicationYear, $ISBN, $registrationNumber, $imperfections, $publisherName) {
        $wrongInputs = array();
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

            else
                array_push($wrongInputs, "Tento autor není v databázi");
        }

        $stmt = $this->connect()->prepare('SELECT id_book FROM book WHERE name = ?;');

        if(!$stmt->execute(array($bookName))) {
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

            if(!$stmt->execute(array($bookName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $stmt = $this->connect()->prepare('SELECT id_book FROM book WHERE name = ?;');

            if(!$stmt->execute(array($bookName))) {
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

        if(!$stmt->execute(array($publisherName))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbPublisher = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPublisher = $dbPublisher[0]["id_publisher"];
        }

        else {
            array_push($wrongInputs, "Tento vydavatel není v databázi");
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
                    array_push($wrongInputs, "Tato závada není v databázi");
                }
            }
        }

        if(!empty($wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            exit();
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

        $stmt = $this->connect()->prepare('INSERT INTO copy(publication_year, ISBN, registration_number, publisher_id_publisher, book_id_book) VALUES(?, ?, ?, ?, ?);');

        if(!$stmt->execute(array($publicationYear, $ISBN, $registrationNumber, $idPublisher, $idBook))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        for ($i = 0; $i < count($imperfections); $i++) {
            if($imperfections[$i] != "NULL") {
                $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE publication_year = ? AND ISBN = ? AND registration_number = ? AND publisher_id_publisher = ? AND book_id_book = ?;');

                if(!$stmt->execute(array($publicationYear, $ISBN, $registrationNumber, $idPublisher, $idBook))) {
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