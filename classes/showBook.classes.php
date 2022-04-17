<?php

class ShowBook extends DatabaseHandler {

    protected function checkISBN($ISBN) {
        $stmt = $this->connect()->prepare('SELECT copy.ISBN FROM copy WHERE copy.ISBN = ?;');
        if(!$stmt->execute(array($ISBN))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function getBook($ISBN) {

        $stmt1 = $this->connect()->prepare(
        'SELECT copy.id_copy, book.id_book, book.name book, copy.ISBN, copy.incremental_number, udc.name UDC, user.last_name, copy.acquisition_date, copy.price, copy.purchase_document, seller.name seller, copy.publication_year, publication_place.name publication_place, publisher.name publisher, copy.issue_number, copy.page_count, signature.name signature
        FROM book
        INNER JOIN copy
        ON copy.book_id_book = book.id_book
        LEFT JOIN udc
        ON copy.UDC_id_UDC = udc.id_UDC
        LEFT JOIN seller
        ON copy.seller_id_seller = seller.id_seller
        LEFT JOIN publication_place
        ON copy.publication_place_id_publication_place = publication_place.id_publication_place
        LEFT JOIN publisher
        ON copy.publisher_id_publisher = publisher.id_publisher
        LEFT JOIN signature
        ON copy.signature_id_signature = signature.id_signature
        LEFT JOIN borrowing
        ON copy.id_copy = borrowing.copy_id_copy
        LEFT JOIN user
        ON borrowing.user_id_user = user.id_user
        WHERE ISBN = ?;');

        if(!$stmt1->execute(array($ISBN))) {
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

        $dbAllBooks = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        echo("<table>");
        echo("<tr><th>Jméno autora</th>");
        for ($i = 0; $i < $stmt1->rowCount(); $i++) {
            array_push($books, $dbAllBooks[$i]["id_copy"]);
            echo("<td>");
            for ($j = 0; $j < count($authors); $j++) {
                if($authors[$j][0] == $dbAllBooks[$i]["id_book"])
                    echo($authors[$j][1]) . "<br />";
            }
        echo("</td></tr><tr><th>Název knihy</th><td>" . $dbAllBooks[$i]["book"] .
        "</td></tr><tr><th>Přírůstkové číslo</th><td>" . $dbAllBooks[$i]["incremental_number"] .
        "</td></tr><tr><th>Datum zařazení do knihovny</th><td>" . date("d-m-Y", strtotime($dbAllBooks[$i]["acquisition_date"])) .
        "</td></tr><tr><th>Cena</th><td>" . $dbAllBooks[$i]["price"] .
        "</td></tr><tr><th>Doklad o koupi</th><td>" . $dbAllBooks[$i]["purchase_document"] .
        "</td></tr><tr><th>Získáno od</th><td>" . $dbAllBooks[$i]["seller"] .
        "</td></tr><tr><th>Rok vydání</th><td>" . $dbAllBooks[$i]["publication_year"] .
        "</td></tr><tr><th>Místo vydání</th><td>" . $dbAllBooks[$i]["publication_place"] .
        "</td></tr><tr><th>Vydavatel</th><td>" . $dbAllBooks[$i]["publisher"] .
        "</td></tr><tr><th>Číslo vydání</th><td>" . $dbAllBooks[$i]["issue_number"] .
        "</td></tr><tr><th>Počet stran</th><td>" . $dbAllBooks[$i]["page_count"] .
        "</td></tr><tr><th>Mezinárodní desetinné třídění</th><td>" . $dbAllBooks[$i]["UDC"] .
        "</td></tr><tr><th>Signatura</th><td>" . $dbAllBooks[$i]["signature"] .
        "</td></tr><tr><th>ISBN</th><td>" . $dbAllBooks[$i]["ISBN"] .
        "</td></tr><tr><th>Závady</th><td>");
            for ($j = 0; $j < count($imperfections); $j++) {
                if($imperfections[$j][0] == $dbAllBooks[$i]["id_copy"])
                    echo($imperfections[$j][1]) . "<br />";
            }
        }
        echo("</td></tr></table>");
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
}
?>