<?php

class AddImperfection extends DatabaseHandler {

    protected function checkImperfection($imperfection) {
        $stmt = $this->connect()->prepare('SELECT name FROM imperfection WHERE name = ?;');

        if(!$stmt->execute(array($imperfection))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setImperfection($imperfection) {
        $stmt = $this->connect()->prepare('INSERT INTO imperfection(name) VALUES(?);');

        if(!$stmt->execute(array($imperfection))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>