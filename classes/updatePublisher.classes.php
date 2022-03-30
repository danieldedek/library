<?php

class UpdatePublisher extends DatabaseHandler {

    protected function checkPublisher($oldPublisher) {
        $stmt = $this->connect()->prepare('SELECT name FROM publisher WHERE name = ?;');

        if(!$stmt->execute(array($oldPublisher))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function setPublisher($oldPublisher, $newPublisher) {
        $stmt = $this->connect()->prepare('UPDATE publisher SET name=? WHERE name=?;');

        if(!$stmt->execute(array($newPublisher, $oldPublisher))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>