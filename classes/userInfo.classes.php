<?php

class UserInfo extends DatabaseHandler {

    protected function getBorrowedBooks($idUser) {

        $stmt1 = $this->connect()->prepare(
        'SELECT copy.id_copy, book.id_book, book.name book, copy.ISBN, borrowing.from_date
        FROM book
        INNER JOIN copy
        ON copy.book_id_book = book.id_book
        LEFT JOIN borrowing
        ON copy.id_copy = borrowing.copy_id_copy
        LEFT JOIN user
        ON borrowing.user_id_user = user.id_user
        WHERE borrowing.user_id_user = ?;');

        if(!$stmt1->execute(array($idUser))) {
            $stmt1 = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt1->rowCount() == 0) {
            $stmt1 = null;
            echo '<div class="wrapper"><p>Žádné aktuálně vypůjčené knihy</p></div>';
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

        $dbBorrowing = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        echo('<p class="title">Aktuální výpůjčky</p><table>');
        echo("<tr><th>Jméno autora</th><th>Název knihy</th><th>ISBN</th><th>Vypůjčeno</th><th>Vrátit do</th></tr>");
        for ($i = 0; $i < $stmt1->rowCount(); $i++) {
            array_push($books, $dbBorrowing[$i]["id_copy"]);
            echo("<tr><td>");
            for ($j = 0; $j < count($authors); $j++) {
                if($authors[$j][0] == $dbBorrowing[$i]["id_book"])
                    echo($authors[$j][1]) . "<br />";
            }
            echo("</td><td>" . $dbBorrowing[$i]["book"] . "</td><td>" . $dbBorrowing[$i]["ISBN"] . "</td><td>" . date("d-m-Y", strtotime($dbBorrowing[$i]["from_date"])) . "</td><td>" . date("d-m-Y", strtotime("+1 month", strtotime($dbBorrowing[$i]["from_date"]))) . "</td></tr>");
        }
        echo("</table>");
    }

    protected function getBorrowingHistory($idUser) {

        $stmt1 = $this->connect()->prepare(
        'SELECT copy.id_copy, book.id_book, book.name book, copy.ISBN, borrowing_history.from_date, borrowing_history.returned_date
        FROM book
        INNER JOIN copy
        ON copy.book_id_book = book.id_book
        LEFT JOIN borrowing_history
        ON copy.id_copy = borrowing_history.copy_id_copy
        LEFT JOIN user
        ON borrowing_history.user_id_user = user.id_user
        WHERE borrowing_history.user_id_user = ?;');

        if(!$stmt1->execute(array($idUser))) {
            $stmt1 = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt1->rowCount() == 0) {
            $stmt1 = null;
            echo '<div class="wrapper"><p>Prázdná historie výpůjček</p></div>';
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

        $dbBorrowing = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        echo('<br /><p class="title">Historie výpůjček</p><table>');
        echo("<tr><th>Jméno autora</th><th>Název knihy</th><th>ISBN</th><th>Vypůjčeno</th><th>Vráceno</th></tr>");
        for ($i = 0; $i < $stmt1->rowCount(); $i++) {
            array_push($books, $dbBorrowing[$i]["id_copy"]);
            echo("<tr><td>");
            for ($j = 0; $j < count($authors); $j++) {
                if($authors[$j][0] == $dbBorrowing[$i]["id_book"])
                    echo($authors[$j][1]) . "<br />";
            }
            echo("</td><td>" . $dbBorrowing[$i]["book"] . "</td><td>" . $dbBorrowing[$i]["ISBN"] . "</td><td>" . date("d-m-Y", strtotime($dbBorrowing[$i]["from_date"])) . "</td><td>" . date("d-m-Y", strtotime($dbBorrowing[$i]["returned_date"])) . "</td></tr>");
        }
        echo("</table>");
    }

    protected function setSendMail($sendMail) {
        $stmt = $this->connect()->prepare('UPDATE user SET send_mail=? WHERE id_user=?;');

        if(!$stmt->execute(array($sendMail, unserialize($_SESSION['user'])->getIdUser()))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        echo "Úspěšně změněno, změna se v informacích o uživateli projeví až po opětovném přihlášení";
    }
}
?>