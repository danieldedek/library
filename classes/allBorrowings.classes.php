<?php

class AllBorrowings extends DatabaseHandler {

    protected function getAllBorrowings() {

        $stmt1 = $this->connect()->prepare(
        'SELECT copy.id_copy, book.id_book, book.name book, copy.ISBN, copy.incremental_number, udc.name UDC, user.last_name, borrowing.from_date, borrowing.extended
        FROM book
        INNER JOIN copy
        ON copy.book_id_book = book.id_book
        INNER JOIN publisher
        ON copy.publisher_id_publisher = publisher.id_publisher
        INNER JOIN udc
        ON copy.UDC_id_UDC = udc.id_UDC
        INNER JOIN borrowing
        ON copy.id_copy = borrowing.copy_id_copy
        INNER JOIN user
        ON borrowing.user_id_user = user.id_user;');

        if(!$stmt1->execute(array())) {
            $stmt1 = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt1->rowCount() == 0) {
            $stmt1 = null;
            echo '<div class="wrapper"><p>Žádné aktuální výpůjčky v databázi</p></div>';
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

        $pagesCount = ceil($stmt1->rowCount()/2);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*2;

        $stmt = $this->connect()->prepare(
            'SELECT copy.id_copy, book.id_book, book.name book, copy.ISBN, copy.incremental_number, udc.name UDC, user.last_name, borrowing.from_date, borrowing.extended
            FROM book
            INNER JOIN copy
            ON copy.book_id_book = book.id_book
            INNER JOIN publisher
            ON copy.publisher_id_publisher = publisher.id_publisher
            INNER JOIN udc
            ON copy.UDC_id_UDC = udc.id_UDC
            INNER JOIN borrowing
            ON copy.id_copy = borrowing.copy_id_copy
            INNER JOIN user
            ON borrowing.user_id_user = user.id_user
            LIMIT ' . $thisPageFirstResult .  ',2;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $dbAllBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo("<table>");
        echo("<tr><th>Jméno autora</th><th>Název knihy</th><th>ISBN</th><th>Přírůstkové číslo</th><th>MDT</th><th>Zapůjčeno</th><th>Zapůjčeno</th><th>Vrátit</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($books, $dbAllBooks[$i]["id_copy"]);
            echo("<tr><td>");
            for ($j = 0; $j < count($authors); $j++) {
                if($authors[$j][0] == $dbAllBooks[$i]["id_book"])
                    echo($authors[$j][1]) . "<br />";
            }
            echo('</td><td><a href="showBook.php?ISBN=' . $dbAllBooks[$i]["ISBN"] . '">' . $dbAllBooks[$i]["book"] . "</a></td><td>" . $dbAllBooks[$i]["ISBN"] . "</td><td>" . $dbAllBooks[$i]["incremental_number"] . "</td><td>" . $dbAllBooks[$i]["UDC"] . "</td><td>" . $dbAllBooks[$i]["last_name"] . "</td><td>" . date("d-m-Y", strtotime($dbAllBooks[$i]["from_date"])) . "</td><td>" . date("d-m-Y", strtotime("+1 month", strtotime($dbAllBooks[$i]["from_date"]))) . "</td>");
            echo('<td><form method="POST"><button type="submit" name="returnButton" class="button" value="'.$i.'">Vrátit</button></form></td>');
            if($dbAllBooks[$i]["extended"] == 0) {
                echo('<td><form method="POST"><button type="submit" name="extendButton" class="button" value="'.$i.'">Prodloužit</button></form></td></tr>');
            }
            else
                echo('</tr>');
        }
        echo("</table>");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allBooks.php?page=' . $page . '">' . $page . '</a>');
        }

        echo("</div>");

        $stmt1 = null;
        $stmt = null;
        
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

        if(isset($_POST["extendButton"])) {

            $idCopy = $books[$_POST["extendButton"]];
        
            $stmt = $this->connect()->prepare('UPDATE borrowing SET from_date = DATE_ADD(from_date, INTERVAL 1 MONTH), extended = 1 WHERE copy_id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
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