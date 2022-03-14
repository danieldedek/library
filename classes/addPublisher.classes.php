<?php

class AddPublisher extends DatabaseHandler {

    protected function checkPublisher($publisherName) {
        $stmt = $this->connect()->prepare('SELECT name FROM publisher WHERE name = ?;');

        if(!$stmt->execute(array($publisherName))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setPublisher($publisherName) {
        $stmt = $this->connect()->prepare('INSERT INTO publisher(name) VALUES(?);');

        if(!$stmt->execute(array($publisherName))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>