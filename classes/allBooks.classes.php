<?php

class AllBooks extends DatabaseHandler {

    protected function getAllBooks() {

        $stmt = $this->connect()->prepare(
        'SELECT copy.id_copy, author.names_before_key, author.prefix_to_key, author.key_name, author.names_after_key, author.suffix_to_key, book.name book, publisher.name, copy.publication_date, borrowing.from_date, borrowing.to_date, imperfection.name imperfection
        FROM author
        INNER JOIN book_has_author
        ON author.id_author = book_has_author.author_id_author
        INNER JOIN book
        ON book.id_book = book_has_author.book_id_book
        INNER JOIN copy
        ON copy.book_id_book = book.id_book
        INNER JOIN publisher
        ON copy.publisher_id_publisher = publisher.id_publisher
        INNER JOIN borrowing
        ON copy.publisher_id_publisher = borrowing.copy_id_copy
        LEFT JOIN to_repair
        ON to_repair.copy_id_copy = copy.id_copy
        LEFT JOIN imperfection
        ON to_repair.imperfection_id_imperfection = imperfection.id_imperfection;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádné knihy v databázi</p></div>';
            return;
        }

        $dbAllBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            echo("<tr><td>" . $dbAllBooks[$i]["names_before_key"] . "</td><td>" . $dbAllBooks[$i]["prefix_to_key"] . "</td><td>" . $dbAllBooks[$i]["key_name"] . "</td><td>" . $dbAllBooks[$i]["names_after_key"] . "</td><td>" . $dbAllBooks[$i]["suffix_to_key"] . "</td><td>" . $dbAllBooks[$i]["book"] . "</td><td>" . $dbAllBooks[$i]["name"] . "</td><td>" . $dbAllBooks[$i]["publication_date"] . "</td><td>" . $dbAllBooks[$i]["from_date"] . "</td><td>" . $dbAllBooks[$i]["to_date"] . "</td><td>" . $dbAllBooks[$i]["imperfection"] . "</td></tr>");
        }
        echo("</table>");
    }
}
?>