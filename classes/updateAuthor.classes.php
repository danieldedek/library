<?php

class UpdateAuthor extends DatabaseHandler {

    protected function checkAuthor($oldName) {
        $stmt = $this->connect()->prepare('SELECT name FROM author WHERE name = ?;');
        if(!$stmt->execute(array($oldName))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function setAuthor($oldName, $newName) {
        $stmt = $this->connect()->prepare('UPDATE author SET name=? WHERE name=?;');

        if(!$stmt->execute(array($newName, $oldName))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}