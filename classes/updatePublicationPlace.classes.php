<?php

class UpdatePublicationPlace extends DatabaseHandler {

    protected function checkPublicationPlace($oldPublicationPlace) {
        $stmt = $this->connect()->prepare('SELECT name FROM publication_place WHERE name = ?;');

        if(!$stmt->execute(array($oldPublicationPlace))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function setPublicationPlace($oldPublicationPlace, $newPublicationPlace) {
        $stmt = $this->connect()->prepare('UPDATE publication_place SET name=? WHERE name=?;');

        if(!$stmt->execute(array($newPublicationPlace, $oldPublicationPlace))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>