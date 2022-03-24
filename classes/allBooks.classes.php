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
        LEFT JOIN borrowing
        ON copy.id_copy = borrowing.copy_id_copy
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

        $books = array();

        $dbAllBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        echo("<tr><th>names_before_key</th><th>prefix_to_key</th><th>key_name</th><th>names_after_key</th><th>suffix_to_key</th><th>Název knihy</th><th>Vydavatelství</th><th>Rok vydání</th><th>Závada</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($books, $dbAllBooks[$i]["id_copy"]);
            echo("<tr><td>" . $dbAllBooks[$i]["names_before_key"] . "</td><td>" . $dbAllBooks[$i]["prefix_to_key"] . "</td><td>" . $dbAllBooks[$i]["key_name"] . "</td><td>" . $dbAllBooks[$i]["names_after_key"] . "</td><td>" . $dbAllBooks[$i]["suffix_to_key"] . "</td><td>" . $dbAllBooks[$i]["book"] . "</td><td>" . $dbAllBooks[$i]["name"] . "</td><td>" . $dbAllBooks[$i]["publication_date"] . "</td><td>" . $dbAllBooks[$i]["imperfection"]);
            if($this->isBorrowed($dbAllBooks[$i]["id_copy"]))
                echo("</td><td>" . $dbAllBooks[$i]["to_date"] . '</td><td><form method="POST"><button type="submit" name="returnButton" class="button" value="'.$i.'">Vrátit</button></form>');
            else
                echo('</td><td><form method="POST"><button type="submit" name="borrowButton" class="button" value="'.$i.'">Vypůjčit</button></form>');
            echo('</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td><td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table></div>");

        $stmt = null;
        
        if(isset($_POST["borrowButton"])) {

            $idCopy = $books[$_POST["borrowButton"]];
            $idUser = unserialize($_SESSION['user'])->getIdUser();
        
            $stmt = $this->connect()->prepare('INSERT INTO borrowing(user_id_user, copy_id_copy, from_date, to_date, extension_count) VALUES(?, ?, NOW(), NOW() + INTERVAL 1 MONTH, ?);');
        
            if(!$stmt->execute(array($idUser, $idCopy, '0'))) {
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

        if(isset($_POST["deleteButton"])) {

            $idCopy = $books[$_POST["deleteButton"]];

            if($this->isBorrowed($idCopy)) {
                $stmt = $this->connect()->prepare('DELETE FROM borrowing WHERE copy_id_copy = ?;');
        
                if(!$stmt->execute(array($idCopy))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    return;
                }

                $stmt = null;
            }

            $stmt = $this->connect()->prepare('DELETE FROM to_repair WHERE copy_id_copy = ?;');
        
            if(!$stmt->execute(array($idCopy))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
        
            $stmt = $this->connect()->prepare('DELETE FROM copy WHERE id_copy = ?;');
        
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
}
?>