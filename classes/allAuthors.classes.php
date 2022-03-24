<?php

class AllAuthors extends DatabaseHandler {

    protected function getAllAuthors() {

        $stmt = $this->connect()->prepare(
        'SELECT id_author, names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author;');

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
        echo("<tr><th>names_before_key</th><th>prefix_to_key</th><th>key_name</th><th>names_after_key</th><th>suffix_to_key</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($authors, $dbAllauthors[$i]["id_author"]);
            echo("<tr><td>" . $dbAllauthors[$i]["names_before_key"] . "</td><td>" . $dbAllauthors[$i]["prefix_to_key"] . "</td><td>" . $dbAllauthors[$i]["key_name"] . "</td><td>" . $dbAllauthors[$i]["names_after_key"] . "</td><td>" . $dbAllauthors[$i]["suffix_to_key"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td><td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
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
}
?>