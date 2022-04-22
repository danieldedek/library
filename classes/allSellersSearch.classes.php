<?php

class AllSellersSearch extends DatabaseHandler {

    protected function getAllSellers($seller) {

        $stmt = $this->connect()->prepare('SELECT id_seller, name FROM seller WHERE name LIKE "%' . $seller . '%";');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádní prodejci v databázi</p></div>';
            return;
        }

        $sellers = array();

        $dbAllSellers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo("<table>");
        echo('<tr><th>Prodejce</th><th></th></tr>');
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($sellers, $dbAllSellers[$i]["id_seller"]);
            echo("<tr><td>" . $dbAllSellers[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllSellers[$i]["id_seller"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table><br />");
        echo("</div>");

        $stmt = null;
    }

    protected function getAllSellersHelp($seller) {

        $stmt = $this->connect()->prepare('SELECT id_seller, name FROM seller WHERE name LIKE "%' . $seller . '%";');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádní prodejci v databázi</p></div>';
            return;
        }

        $sellers = array();

        $dbAllSellers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($sellers, $dbAllSellers[$i]["id_seller"]);
        }

        if(isset($_POST["editButton"])) {

            $idSeller = $sellers[$_POST["editButton"]];

            $stmt = $this->connect()->prepare('SELECT name FROM seller WHERE id_seller = ?;');
        
            if(!$stmt->execute(array($idSeller))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbSellers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nameSeller = $dbSellers[0]["name"];

            $stmt = null;

            header('Location: updateSeller.php?seller=' . $nameSeller);
        }

        if(isset($_POST["deleteButton"])) {

            $idSeller = $sellers[$_POST["deleteButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM seller WHERE id_seller = ?;');
        
            if(!$stmt->execute(array($idSeller))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }
    }

    protected function isUsed($idSeller) {
        
        $stmt = $this->connect()->prepare(
        'SELECT seller_id_seller FROM copy WHERE seller_id_seller = ?;');

        if(!$stmt->execute(array($idSeller))) {
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