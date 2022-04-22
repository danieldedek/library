<?php

class AllBorrowings extends DatabaseHandler {

    protected function getAllBorrowings($order, $sort) {

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
        ON borrowing.user_id_user = user.id_user
        WHERE borrowing.lasting = 0
        ORDER BY ' . $order .  ' ' . $sort .  ';');

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

        $pagesCount = ceil($stmt1->rowCount()/50);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*50;

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
            WHERE borrowing.lasting = 0
            ORDER BY ' . $order .  ' ' . $sort . ' 
            LIMIT ' . $thisPageFirstResult .  ',50;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $dbAllBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($sort == 'DESC')
            $sort = 'ASC';
        else 
            $sort = 'DESC';

        echo("<table>");
        echo('<tr><th>Jméno autora</th><th><a href="allBorrowings.php?order=book&sort=' . $sort . '">Název knihy</a></th><th><a href="allBorrowings.php?order=ISBN&sort=' . $sort . '">ISBN</a></th><th><a href="allBorrowings.php?order=incremental_number&sort=' . $sort . '">Přírůstkové číslo</a></th><th><a href="allBorrowings.php?order=UDC&sort=' . $sort . '">MDT</a></th><th>Zapůjčeno</th><th>Zapůjčeno</th><th>Vrátit</th><th></th><th></th><th></th></tr>');
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
                echo('<td><form method="POST"><button type="submit" name="extendButton" class="button" value="'.$i.'">Prodloužit</button></form></td>');
            }
            echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Zrušit</button></form></td></tr>');
        }
        echo("</table><br />");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allBooks.php?page=' . $page . '" class="page">' . $page . '</a>');
        }

        echo("</div>");

        $stmt1 = null;
        $stmt = null;
        
        if(isset($_POST["returnButton"])) {

            $idCopy = $books[$_POST["returnButton"]];

            $stmt = $this->connect()->prepare('SELECT * FROM borrowing WHERE copy_id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbBorrowing = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $this->connect()->prepare('INSERT INTO borrowing_history(user_id_user, copy_id_copy, from_date, extended, user_id_lent_by, lasting, user_id_received_by, returned_date) VALUES(?, ?, ?, ?, ?, ?, ?, ?);');
        
            if(!$stmt->execute(array($dbBorrowing[0]["user_id_user"], $dbBorrowing[0]["copy_id_copy"], $dbBorrowing[0]["from_date"], $dbBorrowing[0]["extended"], $dbBorrowing[0]["user_id_lent_by"], $dbBorrowing[0]["lasting"], unserialize($_SESSION['user'])->getIdUser(), date("Y-m-d")))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = $this->connect()->prepare('DELETE FROM borrowing WHERE copy_id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");
        }

        if(isset($_POST["deleteButton"])) {

            $idCopy = $books[$_POST["deleteButton"]];

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