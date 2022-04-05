<?php

class UpdateSignature extends DatabaseHandler {

    protected function checkSignature($oldSignature) {
        $stmt = $this->connect()->prepare('SELECT name FROM signature WHERE name = ?;');

        if(!$stmt->execute(array($oldSignature))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function setSignature($oldSignature, $newSignature) {
        $stmt = $this->connect()->prepare('UPDATE signature SET name=? WHERE name=?;');

        if(!$stmt->execute(array($newSignature, $oldSignature))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>