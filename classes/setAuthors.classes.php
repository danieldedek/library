<?php

class SetAuthors extends DatabaseHandler {

    protected function getAuthors($oldISBN) {
        $authors = array();

        $stmt = $this->connect()->prepare(
            'SELECT book.id_book
            FROM book
            INNER JOIN copy
            ON copy.book_id_book = book.id_book
            WHERE copy.ISBN = ?;');
    
        $stmt->execute(array($oldISBN));

        $dbAuthors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $idBook = $dbAuthors[0]["id_book"];

        $stmt = $this->connect()->prepare(
            'SELECT author.name
            FROM author
            INNER JOIN book_has_author
            ON author.id_author = book_has_author.author_id_author
            WHERE book_has_author.book_id_book = ?;');
    
        $stmt->execute(array($idBook));

        $dbAuthors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($authors, $dbAuthors[$i]["name"]);
        }
        return $authors;
    }
}
?>