<?php

class AddBook extends DatabaseHandler {

    protected function checkBook($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName) {
        if (is_null($prefixToKey) && is_null($namesAfterKey) && is_null($suffixToKey) && is_null($imperfection)) {
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key IS NULL AND author.key_name = ? AND author.names_after_key IS NULL AND author.suffix_to_key IS NULL AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $bookName, $publicationDate, $ISBN, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey) && is_null($namesAfterKey) && is_null($suffixToKey)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key IS NULL AND author.key_name = ? AND author.names_after_key IS NULL AND author.suffix_to_key IS NULL AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name = ? AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey) && is_null($namesAfterKey) && is_null($imperfection)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key IS NULL AND author.key_name = ? AND author.names_after_key IS NULL AND author.suffix_to_key = ? AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $suffixToKey, $bookName, $publicationDate, $ISBN, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey) && is_null($suffixToKey) && is_null($imperfection)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key IS NULL AND author.key_name = ? AND author.names_after_key = ? AND author.suffix_to_key IS NULL AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $namesAfterKey, $bookName, $publicationDate, $ISBN, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($namesAfterKey) && is_null($suffixToKey) && is_null($imperfection)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key = ? AND author.key_name = ? AND author.names_after_key IS NULL AND author.suffix_to_key IS NULL AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $bookName, $publicationDate, $ISBN, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey) && is_null($namesAfterKey)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key IS NULL AND author.key_name = ? AND author.names_after_key IS NULL AND author.suffix_to_key = ? AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name = ? AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $suffixToKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey) && is_null($suffixToKey)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key IS NULL AND author.key_name = ? AND author.names_after_key = ? AND author.suffix_to_key IS NULL AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name = ? AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $namesAfterKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey) && is_null($imperfection)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key IS NULL AND author.key_name = ? AND author.names_after_key = ? AND author.suffix_to_key = ? AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $namesAfterKey, $suffixToKey, $bookName, $publicationDate, $ISBN, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($namesAfterKey) && is_null($suffixToKey)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key = ? AND author.key_name = ? AND author.names_after_key IS NULL AND author.suffix_to_key IS NULL AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name = ? AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($namesAfterKey) && is_null($imperfection)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key = ? AND author.key_name = ? AND author.names_after_key IS NULL AND author.suffix_to_key = ? AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $suffixToKey, $bookName, $publicationDate, $ISBN, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($suffixToKey) && is_null($imperfection)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key = ? AND author.key_name = ? AND author.names_after_key = ? AND author.suffix_to_key IS NULL AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $bookName, $publicationDate, $ISBN, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key IS NULL AND author.key_name = ? AND author.names_after_key = ? AND author.suffix_to_key = ? AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name = ? AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $namesAfterKey, $suffixToKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($namesAfterKey)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key = ? AND author.key_name = ? AND author.names_after_key IS NULL AND author.suffix_to_key = ? AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name = ? AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $suffixToKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($suffixToKey)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key = ? AND author.key_name = ? AND author.names_after_key = ? AND author.suffix_to_key IS NULL AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name = ? AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($imperfection)){
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key = ? AND author.key_name = ? AND author.names_after_key = ? AND author.suffix_to_key = ? AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name IS NULL AND publisher.name = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey, $bookName, $publicationDate, $ISBN, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else {
            $stmt = $this->connect()->prepare('SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, copy.publication_date, copy.ISBN, imperfection.name imperfection, publisher.name
            FROM author, book, publisher, copy, book_has_author, imperfection, to_repair
            WHERE author.names_before_key = ? AND author.prefix_to_key = ? AND author.key_name = ? AND author.names_after_key = ? AND author.suffix_to_key = ? AND book.name = ? AND copy.publication_date = ? AND copy.ISBN = ? AND imperfection.name = ? AND publisher.name = ?;');

            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setBook($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName) {
        $stmt = $this->connect()->prepare('SELECT id_author FROM author WHERE names_before_key = ? AND prefix_to_key = ? AND key_name = ? AND names_after_key = ? AND suffix_to_key = ?;');

        if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        $dbAuthor = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $idAuthor = $dbAuthor[0]["id_author"];

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

        $dbPublisher = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $idPublisher = $dbPublisher[0]["id_publisher"];

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

        $stmt = $this->connect()->prepare('INSERT INTO copy(publication_date, ISBN, publisher_id_publisher, book_id_book) VALUES(?, ?, ?, ?);');

        if(!$stmt->execute(array($publicationDate, $ISBN, $idPublisher, $idBook))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if(!is_null($imperfection)) {
            $stmt = $this->connect()->prepare('SELECT id_imperfection FROM imperfection WHERE name = ?;');

            if(!$stmt->execute(array($imperfection))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbImperfection = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idImperfection = $dbImperfection[0]["id_imperfection"];

            $stmt = $this->connect()->prepare('SELECT id_copy FROM copy WHERE publication_date = ? AND ISBN = ? AND publisher_id_publisher = ? AND book_id_book = ?;');

            if(!$stmt->execute(array($publicationDate, $ISBN, $idPublisher, $idBook))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            $dbCopy = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idCopy = $dbCopy[0]["id_copy"];

            $stmt = $this->connect()->prepare('INSERT INTO to_repair(copy_id_copy, imperfection_id_imperfection, date) VALUES(?, ?, ?);');

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