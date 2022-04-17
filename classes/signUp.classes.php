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

        $stmt = $this->connect()->prepare('SELECT mail FROM unverified_user WHERE mail = ?;');

        if(!$stmt->execute(array($mail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setUser($firstName, $lastName, $mail, $password, $verificationCode) {
        $stmt = $this->connect()->prepare('INSERT INTO unverified_user(first_name, last_name, mail, password, verification_code) VALUES(?, ?, ?, ?, ?);');

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if(!$stmt->execute(array($firstName, $lastName, $mail, $hashedPassword, $verificationCode))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>