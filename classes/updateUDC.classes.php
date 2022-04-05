<?php

class UpdateUDC extends DatabaseHandler {

    protected function checkUDC($oldUDC) {
        $stmt = $this->connect()->prepare('SELECT name FROM udc WHERE name = ?;');

        if(!$stmt->execute(array($oldUDC))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function setUDC($oldUDC, $newUDC) {
        $stmt = $this->connect()->prepare('UPDATE udc SET name=? WHERE name=?;');

        if(!$stmt->execute(array($newUDC, $oldUDC))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>