<?php

class AllPublicationPlaces extends DatabaseHandler {

    protected function getAllPublicationPlaces($sort) {

        $stmt = $this->connect()->prepare('SELECT id_publication_place, name FROM publication_place ORDER BY name ' . $sort .  ';');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádná místa vydání v databázi</p></div>';
            return;
        }

        $pagesCount = ceil($stmt->rowCount()/50);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*50;

        $stmt = $this->connect()->prepare('SELECT id_publication_place, name FROM publication_place ORDER BY name ' . $sort .  ' LIMIT ' . $thisPageFirstResult .  ',50;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $publicationPlaces = array();

        $dbAllPublicationPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($sort == 'DESC')
            $sort = 'ASC';
        else 
            $sort = 'DESC';

        echo("<table>");
        echo('<tr><th><a href="allPublicationPlaces.php?sort=' . $sort . '">Místo vydání</a></th><th><form method="POST"><button type="submit" name="searchButton" class="button">Vyhledat</button></form></th></tr>');
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($publicationPlaces, $dbAllPublicationPlaces[$i]["id_publication_place"]);
            echo("<tr><td>" . $dbAllPublicationPlaces[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllPublicationPlaces[$i]["id_publication_place"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table><br />");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allPublicationPlaces.php?page=' . $page . '" class="page">' . $page . '</a>');
        }

        echo("</div>");

        $stmt = null;

        if(isset($_POST["searchButton"])) {

            header('Location: allPublicationPlacesSearch.php');
        }

        if(isset($_POST["editButton"])) {

            $idPublicationPlace = $publicationPlaces[$_POST["editButton"]];

            $stmt = $this->connect()->prepare('SELECT name FROM publication_place WHERE id_publication_place = ?;');
        
            if(!$stmt->execute(array($idPublicationPlace))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbPublicationPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $namePublicationPlace = $dbPublicationPlaces[0]["name"];

            $stmt = null;

            header('Location: updatePublicationPlace.php?publicationPlace=' . $namePublicationPlace);
        }

        if(isset($_POST["deleteButton"])) {

            $idPublicationPlace = $publicationPlaces[$_POST["deleteButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM publication_place WHERE id_publication_place = ?;');
        
            if(!$stmt->execute(array($idPublicationPlace))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }
    }

    protected function isUsed($idPublicationPlace) {
        
        $stmt = $this->connect()->prepare(
        'SELECT publication_place_id_publication_place FROM copy WHERE publication_place_id_publication_place = ?;');

        if(!$stmt->execute(array($idPublicationPlace))) {
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