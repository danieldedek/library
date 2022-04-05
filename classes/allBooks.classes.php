<?php

class AllBooks extends DatabaseHandler {

    protected function getAllBooks() {

        $stmt1 = $this->connect()->prepare(
        'SELECT copy.id_copy, book.id_book, book.name book, publisher.name publisher, copy.publication_year, borrowing.from_date, borrowing.to_date, copy.ISBN, copy.registration_number
        FROM book
        INNER JOIN copy
        ON copy.book_id_book = book.id_book
        INNER JOIN publisher
        ON copy.publisher_id_publisher = publisher.id_publisher
        LEFT JOIN borrowing
        ON copy.id_copy = borrowing.copy_id_copy
        LEFT JOIN to_repair
        ON to_repair.copy_id_copy = copy.id_copy
        LEFT JOIN imperfection
        ON to_repair.imperfection_id_imperfection = imperfection.id_imperfection;');

        if(!$stmt1->execute(array())) {
            $stmt1 = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt1->rowCount() == 0) {
            $stmt1 = null;
            echo '<div class="wrapper"><p>Žádné knihy v databázi</p></div>';
            return;
        }

        $books = array();

        $authors = array();

        $stmt = $this->connect()->prepare(
            'SELECT book_has_author.book_id_book, author.name
            FROM author
            INNER JOIN book_has_author
            ON author.id_author = book_has_author.author_id_author;');
    
        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádní autoři v databázi</p></div>';
            return;
        }

        $dbAllAuthors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($authors, array($dbAllAuthors[$i]["book_id_book"], $dbAllAuthors[$i]["name"]));
        }

        $imperfections = array();

        $stmt = $this->connect()->prepare(
            'SELECT to_repair.copy_id_copy, imperfection.name
            FROM imperfection
            INNER JOIN  to_repair
            ON imperfection.id_imperfection = to_repair.imperfection_id_imperfection;');
    
        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádné závady v databázi</p></div>';
            return;
        }

        $dbAllImperfections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($imperfections, array($dbAllImperfections[$i]["copy_id_copy"], $dbAllImperfections[$i]["name"]));
        }

        $pagesCount = ceil($stmt1->rowCount()/2);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*2;

        $stmt = $this->connect()->prepare(
            'SELECT copy.id_copy, book.id_book, book.name book, publisher.name publisher, copy.publication_year, borrowing.from_date, borrowing.to_date, copy.ISBN, copy.registration_number
            FROM book
            INNER JOIN copy
            ON copy.book_id_book = book.id_book
            INNER JOIN publisher
            ON copy.publisher_id_publisher = publisher.id_publisher
            LEFT JOIN borrowing
            ON copy.id_copy = borrowing.copy_id_copy
            LEFT JOIN to_repair
            ON to_repair.copy_id_copy = copy.id_copy
            LEFT JOIN imperfection
            ON to_repair.imperfection_id_imperfection = imperfection.id_imperfection
            LIMIT ' . $thisPageFirstResult .  ',2;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $dbAllBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo("<table>");
        echo("<tr><th>Jméno autora</th><th>Název knihy</th><th>Vydavatelství</th><th>Rok vydání</th><th>ISBN</th><th>Registrační číslo</th><th>Závada</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($books, $dbAllBooks[$i]["id_copy"]);
            echo("<tr><td>");
            for ($j = 0; $j < count($authors); $j++) {
                if($authors[$j][0] == $dbAllBooks[$i]["id_book"])
                    echo($authors[$j][1]) . "<br />";
            }
            echo("</td><td>" . $dbAllBooks[$i]["book"] . "</td><td>" . $dbAllBooks[$i]["publisher"] . "</td><td>" . $dbAllBooks[$i]["publication_year"] . "</td><td>" . $dbAllBooks[$i]["ISBN"] . "</td><td>" . $dbAllBooks[$i]["registration_number"] . "</td><td>");
            for ($j = 0; $j < count($imperfections); $j++) {
                if($imperfections[$j][0] == $dbAllBooks[$i]["id_copy"])
                    echo($imperfections[$j][1]) . "<br />";
            }
            if($this->isBorrowed($dbAllBooks[$i]["id_copy"]))
                echo("</td><td>" . $dbAllBooks[$i]["to_date"] . '</td><td><form method="POST"><button type="submit" name="returnButton" class="button" value="'.$i.'">Vrátit</button></form>');
            else
                echo('</td><td><form method="POST"><button type="submit" name="borrowButton" class="button" value="'.$i.'">Vypůjčit</button></form>');
            echo('</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td><td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table>");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allBooks.php?page=' . $page . '">' . $page . '</a>');
        }

        echo("</div>");

        $stmt1 = null;
        $stmt = null;
        
        if(isset($_POST["borrowButton"])) {

            $idCopy = $books[$_POST["borrowButton"]];
            $idUser = unserialize($_SESSION['user'])->getIdUser();
        
            $stmt = $this->connect()->prepare('INSERT INTO borrowing(user_id_user, copy_id_copy, from_date, to_date, extension_count, lent_by) VALUES(?, ?, NOW(), NOW() + INTERVAL 1 MONTH, ?, ?);');
        
            if(!$stmt->execute(array($idUser, $idCopy, '0', unserialize($_SESSION['user'])->getIdUser()))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }

        if(isset($_POST["returnButton"])) {

            $idCopy = $books[$_POST["returnButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM borrowing WHERE copy_id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }

        if(isset($_POST["editButton"])) {

            $idCopy = $books[$_POST["editButton"]];

            $stmt = $this->connect()->prepare(
                'SELECT copy.id_copy, book.id_book, book.name book, publisher.name publisher, copy.publication_year, borrowing.from_date, borrowing.to_date, copy.ISBN, copy.registration_number
                FROM book
                INNER JOIN copy
                ON copy.book_id_book = book.id_book
                INNER JOIN publisher
                ON copy.publisher_id_publisher = publisher.id_publisher
                LEFT JOIN borrowing
                ON copy.id_copy = borrowing.copy_id_copy
                LEFT JOIN to_repair
                ON to_repair.copy_id_copy = copy.id_copy
                LEFT JOIN imperfection
                ON to_repair.imperfection_id_imperfection = imperfection.id_imperfection
                WHERE copy.id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $book = $dbBooks[0]["book"];
            $publisher = $dbBooks[0]["publisher"];
            $publicationYear = $dbBooks[0]["publication_year"];
            $ISBN = $dbBooks[0]["ISBN"];
            $registrationNumber = $dbBooks[0]["registration_number"];

            header('Location: addBook.php?bookName=' . $book . '&publisherName=' . $publisher . '&publicationYear=' . $publicationYear . '&ISBN='. $ISBN . '&registrationNumber=' . $registrationNumber);
        }

        if(isset($_POST["deleteButton"])) {

            $idCopy = $books[$_POST["deleteButton"]];

            if($this->isBorrowed($idCopy)) {
                $stmt = $this->connect()->prepare('DELETE FROM borrowing WHERE copy_id_copy = ?;');
        
                if(!$stmt->execute(array($idCopy))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    return;
                }
            }

            $stmt = $this->connect()->prepare('DELETE FROM to_repair WHERE copy_id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $idBook = $this->getIdBook($idCopy);
        
            $stmt = $this->connect()->prepare('DELETE FROM copy WHERE id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;

            if(!$this->isUsed($idBook)) {
                $stmt = $this->connect()->prepare('DELETE FROM book_has_author WHERE book_id_book = ?;');
        
                if(!$stmt->execute(array($idBook))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    return;
                }

                $stmt = $this->connect()->prepare('DELETE FROM book WHERE id_book = ?;');
        
                if(!$stmt->execute(array($idBook))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    return;
                }

                $stmt = null;
            }
            
            header("Refresh:0");

        }
    }

    private function isBorrowed($idCopy) {

        $stmt = $this->connect()->prepare(
        'SELECT copy_id_copy
        FROM borrowing
        WHERE copy_id_copy = ?;');

        if(!$stmt->execute(array($idCopy))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            return false;
        }

        $stmt = null;
        return true;
    }

    private function isUsed($idBook) {

        $stmt = $this->connect()->prepare(
        'SELECT id_copy, book_id_book
        FROM copy
        WHERE book_id_book = ?;');

        if(!$stmt->execute(array($idBook))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            return false;
        }

        $stmt = null;
        return true;
    }

    private function getIdBook($idCopy) {

        $stmt = $this->connect()->prepare(
        'SELECT book_id_book
        FROM copy
        WHERE id_copy = ?;');

        if(!$stmt->execute(array($idCopy))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $dbBook = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $idBook = $dbBook[0]["book_id_book"];

        $stmt = null;

        return $idBook;
    }
}
?>