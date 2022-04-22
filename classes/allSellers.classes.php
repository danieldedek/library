<?php

class AllSellers extends DatabaseHandler {

    protected function getAllSellers($sort) {

        $stmt = $this->connect()->prepare('SELECT id_seller, name FROM seller ORDER BY name ' . $sort .  ';');

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

        $pagesCount = ceil($stmt->rowCount()/50);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*50;

        $stmt = $this->connect()->prepare('SELECT id_seller, name FROM seller ORDER BY name ' . $sort .  ' LIMIT ' . $thisPageFirstResult .  ',50;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $sellers = array();

        $dbAllSellers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($sort == 'DESC')
            $sort = 'ASC';
        else 
            $sort = 'DESC';

        echo("<table>");
        echo('<tr><th><a href="allSellers.php?sort=' . $sort . '">Prodejce</a></th><th><form method="POST"><button type="submit" name="searchButton" class="button">Vyhledat</button></form></th></tr>');
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($sellers, $dbAllSellers[$i]["id_seller"]);
            echo("<tr><td>" . $dbAllSellers[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllSellers[$i]["id_seller"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table><br />");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allSellers.php?page=' . $page . '" class="page">' . $page . '</a>');
        }

        echo("</div>");

        $stmt = null;

        if(isset($_POST["searchButton"])) {

            header('Location: allSellersSearch.php');
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