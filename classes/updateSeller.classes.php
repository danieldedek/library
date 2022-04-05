<?php

class UpdateSeller extends DatabaseHandler {

    protected function checkSeller($oldSeller) {
        $stmt = $this->connect()->prepare('SELECT name FROM seller WHERE name = ?;');

        if(!$stmt->execute(array($oldSeller))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function setSeller($oldSeller, $newSeller) {
        $stmt = $this->connect()->prepare('UPDATE seller SET name=? WHERE name=?;');

        if(!$stmt->execute(array($newSeller, $oldSeller))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>