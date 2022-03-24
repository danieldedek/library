<?php

class AllImperfections extends DatabaseHandler {

    protected function getAllImperfections() {

        $stmt = $this->connect()->prepare(
        'SELECT id_imperfection, name FROM imperfection;');

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

        $imperfections = array();

        $dbAllImperfections = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        echo("<tr><th>Závada</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($imperfections, $dbAllImperfections[$i]["id_imperfection"]);
            echo("<tr><td>" . $dbAllImperfections[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td><td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table></div>");

        $stmt = null;

        if(isset($_POST["deleteButton"])) {

            $idImperfection = $imperfections[$_POST["deleteButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM imperfection WHERE id_imperfection = ?;');
        
            if(!$stmt->execute(array($idImperfection))) {
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