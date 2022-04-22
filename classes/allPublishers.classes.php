<?php

class AllPublishers extends DatabaseHandler {

    protected function getAllPublishers($sort) {

        $stmt = $this->connect()->prepare('SELECT id_publisher, name FROM publisher ORDER BY name ' . $sort .  ';');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádní vydavatelé v databázi</p></div>';
            return;
        }

        $pagesCount = ceil($stmt->rowCount()/50);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*50;

        $stmt = $this->connect()->prepare('SELECT id_publisher, name FROM publisher ORDER BY name ' . $sort .  ' LIMIT ' . $thisPageFirstResult .  ',50;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $publishers = array();

        $dbAllPublishers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($sort == 'DESC')
            $sort = 'ASC';
        else 
            $sort = 'DESC';

        echo("<table>");
        echo('<tr><th><a href="allPublishers.php?sort=' . $sort . '">Vydavatel</a></th><th><form method="POST"><button type="submit" name="searchButton" class="button">Vyhledat</button></form></th></tr>');
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($publishers, $dbAllPublishers[$i]["id_publisher"]);
            echo("<tr><td>" . $dbAllPublishers[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllPublishers[$i]["id_publisher"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table><br />");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allPublishers.php?page=' . $page . '" class="page">' . $page . '</a>');
        }

        echo("</div>");

        $stmt = null;

        if(isset($_POST["searchButton"])) {

            header('Location: allPublishersSearch.php');
        }

        if(isset($_POST["editButton"])) {

            $idPublisher = $publishers[$_POST["editButton"]];

            $stmt = $this->connect()->prepare('SELECT name FROM publisher WHERE id_publisher = ?;');
        
            if(!$stmt->execute(array($idPublisher))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbPublishers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $namePublisher = $dbPublishers[0]["name"];

            $stmt = null;

            header('Location: updatePublisher.php?publisher=' . $namePublisher);
        }

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