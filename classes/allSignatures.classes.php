<?php

class AllSignatures extends DatabaseHandler {

    protected function getAllSignatures() {

        $stmt = $this->connect()->prepare('SELECT id_signature, name FROM signature;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádné signatury v databázi</p></div>';
            return;
        }

        $pagesCount = ceil($stmt->rowCount()/2);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*2;

        $stmt = $this->connect()->prepare('SELECT id_signature, name FROM signature LIMIT ' . $thisPageFirstResult .  ',2;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $signatures = array();

        $dbAllSignatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        echo("<tr><th>Vydavatelství</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($signatures, $dbAllSignatures[$i]["id_signature"]);
            echo("<tr><td>" . $dbAllSignatures[$i]["name"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td>');
            if($this->isUsed($dbAllSignatures[$i]["id_signature"]))
                echo('</tr>');
            else
                echo('<td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table>");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allSignatures.php?page=' . $page . '">' . $page . '</a>');
        }

        echo("</div>");

        $stmt = null;

        if(isset($_POST["editButton"])) {

            $idSignature = $signatures[$_POST["editButton"]];

            $stmt = $this->connect()->prepare('SELECT name FROM signature WHERE id_signature = ?;');
        
            if(!$stmt->execute(array($idSignature))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbSignature = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $nameSignature = $dbSignature[0]["name"];

            $stmt = null;

            header('Location: updateSignature.php?signature=' . $nameSignature);
        }

        if(isset($_POST["deleteButton"])) {

            $idSignature = $signatures[$_POST["deleteButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM signature WHERE id_signature = ?;');
        
            if(!$stmt->execute(array($idSignature))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }
    }

    protected function isUsed($idSignature) {
        
        $stmt = $this->connect()->prepare(
        'SELECT signature_id_signature FROM copy WHERE signature_id_signature = ?;');

        if(!$stmt->execute(array($idSignature))) {
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