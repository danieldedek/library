<?php

class SignUp extends DatabaseHandler {

    protected function checkUser($mail) {
        $stmt = $this->connect()->prepare('SELECT mail FROM user WHERE mail = ?;');

        if(!$stmt->execute(array($mail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setUser($firstName, $keyName, $mail, $password) {
        $stmt = $this->connect()->prepare('INSERT INTO user(first_name, key_name, mail, password, role_id_role, send_mail) VALUES(?, ?, ?, ?, ?, ?);');

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if(!$stmt->execute(array($firstName, $keyName, $mail, $hashedPassword, '1', '1'))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}