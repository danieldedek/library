<?php

class UserInfo extends DatabaseHandler {

    protected function getBorrowedBooks($idUser) {

        $stmt = $this->connect()->prepare(
        'SELECT copy.id_copy, author.names_before_key, author.key_name, book.name book, publisher.name, copy.publication_date, borrowing.from_date, borrowing.to_date, borrowing.extensiton_count
        FROM author, book, publisher, borrowing, copy, book_has_author
        WHERE author.id_author = book_has_author.author_id_author
        AND book.id_book = book_has_author.book_id_book
        AND copy.publisher_id_publisher = borrowing.copy_id_copy
        AND copy.publisher_id_publisher = publisher.id_publisher
        AND copy.book_id_book = book.id_book
        AND borrowing.user_id_user = ?;');

        if(!$stmt->execute(array($idUser))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádné vypůjčené knihy</p></div>';
            return;
        }

        $dbBorrowing = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            echo("<tr><td>" . $dbBorrowing[$i]["names_before_key"] . "</td><td>" . $dbBorrowing[$i]["key_name"] . "</td><td>" . $dbBorrowing[$i]["book"] . "</td><td>" . $dbBorrowing[$i]["name"] . "</td><td>" . $dbBorrowing[$i]["publication_date"] . "</td><td>" . $dbBorrowing[$i]["from_date"] . "</td><td>" . $dbBorrowing[$i]["to_date"] . "</td><td>" . $dbBorrowing[$i]["extensiton_count"] . "</td></tr>");
        }
        echo("</table>");
    }
}
?>