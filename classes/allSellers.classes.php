<?php

class AllSellers extends DatabaseHandler {

    protected function getAllSellers() {

        $stmt = $this->connect()->prepare('SELECT id_seller, name FROM seller;');

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

        $pagesCount = ceil($stmt->rowCount()/2);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*2;

        $stmt = $this->connect()->prepare('SELECT id_seller, name FROM seller LIMIT ' . $thisPageFirstResult .  ',2;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $sellers = array();

        $dbAllSellers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        echo("<tr><th>Vydavatelství</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($sellers, $dbAllSellers[$i]["id_publisher"]);
            echo("<tr><td>" . $dbAllSellers[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllSellers[$i]["id_publisher"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table>");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allSellers.php?page=' . $page . '">' . $page . '</a>');
        }

        echo("</div>");

        $stmt = null;

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