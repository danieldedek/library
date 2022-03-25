<?php

class AddAuthor extends DatabaseHandler {

    protected function checkAuthor($name) {
        $stmt = $this->connect()->prepare('SELECT name FROM author WHERE name = ?;');
        if(!$stmt->execute(array($name))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setAuthor($name) {
        $stmt = $this->connect()->prepare('INSERT INTO author(name) VALUES(?);');

        if(!$stmt->execute(array($name))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}