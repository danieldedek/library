<?php

class UserInfo extends DatabaseHandler {

    protected function getBorrowedBooks($idUser) {

        $stmt = $this->connect()->prepare(
        'SELECT copy.id_copy, author.name author, book.name book, publisher.name publisher, copy.publication_year, imperfection.name imperfection, borrowing.from_date, borrowing.to_date, borrowing.extension_count
        FROM author
        INNER JOIN book_has_author
        ON author.id_author = book_has_author.author_id_author
        INNER JOIN book
        ON book.id_book = book_has_author.book_id_book
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
        WHERE borrowing.user_id_user = ?;');

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
            echo("<tr><td>" . $dbBorrowing[$i]["author"] . "</td><td>" . $dbBorrowing[$i]["book"] . "</td><td>" . $dbBorrowing[$i]["publisher"] . "</td><td>" . $dbBorrowing[$i]["publication_year"] . "</td><td>" . $dbBorrowing[$i]["from_date"] . "</td><td>" . $dbBorrowing[$i]["to_date"] . "</td><td>" . $dbBorrowing[$i]["extension_count"] . "</td><td>" . $dbBorrowing[$i]["imperfection"] . "</td></tr>");
        }
        echo("</table></div>");

        $stmt = null;
    }
}
?>