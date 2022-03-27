<?php

class AllPublishers extends DatabaseHandler {

    protected function getAllPublishers() {

        $stmt = $this->connect()->prepare(
        'SELECT id_publisher, name FROM publisher;');

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

        $publishers = array();

        $dbAllPublishers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        echo("<tr><th>Vydavatelství</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($publishers, $dbAllPublishers[$i]["id_publisher"]);
            echo("<tr><td>" . $dbAllPublishers[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllPublishers[$i]["id_publisher"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table></div>");

        $stmt = null;

        if(isset($_POST["deleteButton"])) {

            $idPublisher = $publishers[$_POST["deleteButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM publisher WHERE id_publisher = ?;');
        
            if(!$stmt->execute(array($idPublisher))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }
    }

    protected function isUsed($idPublisher) {
        
        $stmt = $this->connect()->prepare(
        'SELECT publisher_id_publisher FROM copy WHERE publisher_id_publisher = ?;');

        if(!$stmt->execute(array($idPublisher))) {
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