<?php

class UpdateImperfection extends DatabaseHandler {

    protected function checkImperfection($oldImperfection) {
        $stmt = $this->connect()->prepare('SELECT name FROM imperfection WHERE name = ?;');

        if(!$stmt->execute(array($oldImperfection))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function setImperfection($oldImperfection, $newImperfection) {
        $stmt = $this->connect()->prepare('UPDATE imperfection SET name=? WHERE name=?;');

        if(!$stmt->execute(array($newImperfection, $oldImperfection))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>