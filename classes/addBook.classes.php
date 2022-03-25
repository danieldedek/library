<?php

class AddBook extends DatabaseHandler {

    protected function checkBook($authorName, $bookName, $publicationYear, $ISBN, $registrationNumber, $imperfection, $publisherName) {
        if(is_null($imperfection)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.name author, book.name book, copy.publication_year, copy.ISBN, copy.registration_number, imperfection.name imperfection, publisher.name publisher
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.name = ? AND book.name = ? AND copy.publication_year = ? AND copy.ISBN = ? AND copy.registration_number = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($authorName, $bookName, $publicationYear, $ISBN, $registrationNumber, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else {
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.name author, book.name book, copy.publication_year, copy.ISBN, copy.registration_number, imperfection.name imperfection, publisher.name publisher
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.name = ? AND book.name = ? AND copy.publication_year = ? AND copy.ISBN = ? AND copy.registration_number = ? AND imperfection.name = ? AND publisher.name = ?;');

            if(!$stmt->execute(array($authorName, $bookName, $publicationYear, $ISBN, $registrationNumber, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setBook($authorName, $bookName, $publicationYear, $ISBN, $registrationNumber, $imperfection, $publisherName) {
        $wrongInputs = array();

        $stmt = $this->connect()->prepare('SELECT id_author FROM author WHERE name = ?;');

        if(!$stmt->execute(array($authorName))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0) {
            $dbAuthor = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idAuthor = $dbAuthor[0]["id_author"];
        }

        else {
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

        if(!is_null($imperfection)) {
            $stmt = $this->connect()->prepare('SELECT id_imperfection FROM imperfection WHERE name = ?;');

            if(!$stmt->execute(array($imperfection))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() > 0) {
                $dbImperfection = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $idImperfection = $dbImperfection[0]["id_imperfection"];
            }

            else {
                array_push($wrongInputs, "Tato závada není v databázi");
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

        $stmt = $this->connect()->prepare('INSERT INTO copy(publication_year, ISBN, registration_number, publisher_id_publisher, book_id_book) VALUES(?, ?, ?, ?, ?);');

        if(!$stmt->execute(array($publicationYear, $ISBN, $registrationNumber, $idPublisher, $idBook))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if(!is_null($imperfection)) {
            $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE publication_year = ? AND ISBN = ? AND registration_number = ? AND publisher_id_publisher = ? AND book_id_book = ?;');

            if(!$stmt->execute(array($publicationYear, $ISBN, $registrationNumber, $idPublisher, $idBook))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbCopy = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idCopy = $dbCopy[0]["id_copy"];

            $stmt = $this->connect()->prepare('INSERT INTO to_repair(copy_id_copy, imperfection_id_imperfection, damaged_date) VALUES(?, ?, ?);');

            if(!$stmt->execute(array($idCopy, $idImperfection, date("Y-m-d")))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }
        
        $stmt = null;
    }
}
?>