<?php

class AllImperfections extends DatabaseHandler {

    protected function getAllImperfections($sort) {

        $stmt = $this->connect()->prepare('SELECT id_imperfection, name FROM imperfection ORDER BY name ' . $sort .  ';');

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

        $pagesCount = ceil($stmt->rowCount()/50);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*50;

        $stmt = $this->connect()->prepare('SELECT id_imperfection, name FROM imperfection ORDER BY name ' . $sort .  ' LIMIT ' . $thisPageFirstResult .  ',50;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $imperfections = array();

        $dbAllImperfections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($sort == 'DESC')
            $sort = 'ASC';
        else 
            $sort = 'DESC';

        echo("<table>");
        echo('<tr><th><a href="allImperfections.php?sort=' . $sort . '">Závada</a></th><th><form method="POST"><button type="submit" name="searchButton" class="button">Vyhledat</button></form></th></tr>');
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($imperfections, $dbAllImperfections[$i]["id_imperfection"]);
            echo("<tr><td>" . $dbAllImperfections[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllImperfections[$i]["id_imperfection"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table><br />");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allImperfections.php?page=' . $page . '" class="page">' . $page . '</a>');
        }

        echo("</div>");

        $stmt = null;

        if(isset($_POST["searchButton"])) {

            header('Location: allImperfectionsSearch.php');
        }

        if(isset($_POST["editButton"])) {

            $idImperfection = $imperfections[$_POST["editButton"]];

            $stmt = $this->connect()->prepare('SELECT name FROM imperfection WHERE id_imperfection = ?;');
        
            if(!$stmt->execute(array($idImperfection))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbImperfections = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nameImperfection = $dbImperfections[0]["name"];

            $stmt = null;

            header('Location: updateImperfection.php?imperfectionName=' . $nameImperfection);
        }

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

    protected function isUsed($idImperfection) {
        
        $stmt = $this->connect()->prepare(
        'SELECT imperfection_id_imperfection FROM to_repair WHERE imperfection_id_imperfection = ?;');

        if(!$stmt->execute(array($idImperfection))) {
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