<?php

class AllBooks extends DatabaseHandler {

    protected function getAllBooks() {

        $stmt1 = $this->connect()->prepare(
        'SELECT copy.id_copy, book.id_book, book.name book, copy.ISBN, copy.incremental_number, udc.name UDC, user.last_name
        FROM book
        INNER JOIN copy
        ON copy.book_id_book = book.id_book
        INNER JOIN publisher
        ON copy.publisher_id_publisher = publisher.id_publisher
        LEFT JOIN udc
        ON copy.UDC_id_UDC = udc.id_UDC
        LEFT JOIN borrowing
        ON copy.id_copy = borrowing.copy_id_copy
        LEFT JOIN user
        ON borrowing.user_id_user = user.id_user;');

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

        $pagesCount = ceil($stmt1->rowCount()/2);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*2;

        $stmt = $this->connect()->prepare(
            'SELECT copy.id_copy, book.id_book, book.name book, copy.ISBN, copy.incremental_number, udc.name UDC, user.last_name
            FROM book
            INNER JOIN copy
            ON copy.book_id_book = book.id_book
            INNER JOIN publisher
            ON copy.publisher_id_publisher = publisher.id_publisher
            LEFT JOIN udc
            ON copy.UDC_id_UDC = udc.id_UDC
            LEFT JOIN borrowing
            ON copy.id_copy = borrowing.copy_id_copy
            LEFT JOIN user
            ON borrowing.user_id_user = user.id_user
            LIMIT ' . $thisPageFirstResult .  ',2;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $dbAllBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo("<table>");
        echo("<tr><th>Jméno autora</th><th>Název knihy</th><th>ISBN</th><th>Přírůstkové číslo</th><th>MDT</th><th>Zapůjčeno</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($books, $dbAllBooks[$i]["id_copy"]);
            echo("<tr><td>");
            for ($j = 0; $j < count($authors); $j++) {
                if($authors[$j][0] == $dbAllBooks[$i]["id_book"])
                    echo($authors[$j][1]) . "<br />";
            }
            echo('</td><td><a href="showBook.php?ISBN=' . $dbAllBooks[$i]["ISBN"] . '">' . $dbAllBooks[$i]["book"] . "</a></td><td>" . $dbAllBooks[$i]["ISBN"] . "</td><td>" . $dbAllBooks[$i]["incremental_number"] . "</td><td>" . $dbAllBooks[$i]["UDC"] . "</td>");
            if($this->isBorrowed($dbAllBooks[$i]["id_copy"]))
                echo("<td>" . $dbAllBooks[$i]["last_name"] . '</td><td><form method="POST"><button type="submit" name="returnButton" class="button" value="'.$i.'">Vrátit</button></form>');
            else
                echo('<td><form method="POST"><button type="submit" name="borrowButton" class="button" value="'.$i.'">Vypůjčit</button></form>');
            echo('</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if(!$this->isBorrowed($dbAllBooks[$i]["id_copy"]))
                echo ('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
            else
             echo ('</tr>');
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

            header('Location: allUsers.php?idCopy=' . $idCopy);
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
                'SELECT copy.id_copy, book.id_book, book.name book, copy.incremental_number, copy.acquisition_date, copy.price, copy.purchase_document, seller.name seller, copy.publication_year, publication_place.name publication_place, publisher.name publisher, copy.issue_number, copy.page_count, udc.name UDC, signature.name signature, copy.ISBN
                FROM book
                INNER JOIN copy
                ON copy.book_id_book = book.id_book
                INNER JOIN publisher
                ON copy.publisher_id_publisher = publisher.id_publisher
                LEFT JOIN udc
                ON copy.UDC_id_UDC = udc.id_UDC
                LEFT JOIN seller
                ON copy.seller_id_seller = seller.id_seller
                LEFT JOIN publication_place
                ON copy.publication_place_id_publication_place = publication_place.id_publication_place
                LEFT JOIN signature
                ON copy.signature_id_signature = signature.id_signature
                WHERE copy.id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $book = $dbBooks[0]["book"];
            $incrementalNumber = $dbBooks[0]["incremental_number"];
            $acquisitionDate = $dbBooks[0]["acquisition_date"];
            $price = $dbBooks[0]["price"];
            $purchaseDocument = $dbBooks[0]["purchase_document"];
            $seller = $dbBooks[0]["seller"];
            $publicationYear = $dbBooks[0]["publication_year"];
            $publicationPlace = $dbBooks[0]["publication_place"];
            $publisher = $dbBooks[0]["publisher"];
            $issueNumber = $dbBooks[0]["issue_number"];
            $pageCount = $dbBooks[0]["page_count"];
            $UDC = $dbBooks[0]["UDC"];
            $signature = $dbBooks[0]["signature"];
            $ISBN = $dbBooks[0]["ISBN"];

            header('Location: addBook.php?book=' . $book . '&incrementalNumber=' . $incrementalNumber . '&acquisitionDate=' . $acquisitionDate . '&price=' . $price . '&purchaseDocument=' . $purchaseDocument. '&seller=' . $seller . '&publicationYear=' . $publicationYear. '&publicationPlace=' . $publicationPlace . '&publisher=' . $publisher . '&issueNumber=' . $issueNumber . '&pageCount=' . $pageCount . '&UDC=' . $UDC . '&signature=' . $signature . '&ISBN='. $ISBN);
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