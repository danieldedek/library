<?php

class AllAuthors extends DatabaseHandler {

    protected function getAllAuthors() {

        $stmt = $this->connect()->prepare(
        'SELECT id_author, name FROM author;');

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

        $authors = array();

        $dbAllauthors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        echo("<tr><th>Jméno autora</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($authors, $dbAllauthors[$i]["id_author"]);
            echo("<tr><td>" . $dbAllauthors[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllauthors[$i]["id_author"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table></div>");

        $stmt = null;

        if(isset($_POST["deleteButton"])) {

            $idAuthor = $authors[$_POST["deleteButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM author WHERE id_author = ?;');
        
            if(!$stmt->execute(array($idAuthor))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }
    }

    protected function isUsed($idAuthor) {
        
        $stmt = $this->connect()->prepare(
        'SELECT author_id_author FROM book_has_author WHERE author_id_author = ?;');

        if(!$stmt->execute(array($idAuthor))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            return false;
        }
    return true;
    }
}
?>