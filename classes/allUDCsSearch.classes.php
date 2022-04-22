<?php

class AllUDCs extends DatabaseHandler {

    protected function getAllUDCs($UDC) {

        $stmt = $this->connect()->prepare('SELECT id_UDC, name FROM udc WHERE name LIKE "%' . $UDC . '%";');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádná mezinárodní desetinná třídění v databázi</p></div>';
            return;
        }

        $UDCs = array();

        $dbAllUDCs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo("<table>");
        echo('<tr><th>Mezinárodní desetinné třídění</th><th></th></tr>');
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($UDCs, $dbAllUDCs[$i]["id_UDC"]);
            echo("<tr><td>" . $dbAllUDCs[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllUDCs[$i]["id_UDC"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table><br />");
        echo("</div>");

        $stmt = null;
    }

    protected function getAllUDCs($UDC) {

        $stmt = $this->connect()->prepare('SELECT id_UDC, name FROM udc WHERE name LIKE "%' . $UDC . '%";');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádná mezinárodní desetinná třídění v databázi</p></div>';
            return;
        }

        $UDCs = array();

        $dbAllUDCs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($UDCs, $dbAllUDCs[$i]["id_UDC"]);
        }

        $stmt = null;

        if(isset($_POST["editButton"])) {

            $idUDC = $UDCs[$_POST["editButton"]];

            $stmt = $this->connect()->prepare('SELECT name FROM udc WHERE id_UDC = ?;');
        
            if(!$stmt->execute(array($idUDC))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbUDCs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nameUDC = $dbUDCs[0]["name"];

            $stmt = null;

            header('Location: updateUDC.php?UDC=' . $nameUDC);
        }

        if(isset($_POST["deleteButton"])) {

            $idUDC = $UDCs[$_POST["deleteButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM udc WHERE id_UDC = ?;');
        
            if(!$stmt->execute(array($idUDC))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }
    }

    protected function isUsed($idUDC) {
        
        $stmt = $this->connect()->prepare(
        'SELECT UDC_id_UDC FROM copy WHERE UDC_id_UDC = ?;');

        if(!$stmt->execute(array($idUDC))) {
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