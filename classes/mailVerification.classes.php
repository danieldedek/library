<?php

class MailVerification extends DatabaseHandler {

    protected function verify($verificationCode, $mail) {
        $stmt = $this->connect()->prepare('SELECT id_user FROM unverified_user WHERE verification_code = ? AND mail = ?;');

        if(!$stmt->execute(array($verificationCode, $mail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function addToUser($verificationCode, $mail) {
        $stmt = $this->connect()->prepare('SELECT first_name, last_name, password FROM unverified_user WHERE verification_code = ? AND mail = ?;');

        if(!$stmt->execute(array($verificationCode, $mail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        $dbUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $firstName = $dbUser[0]["first_name"];
        $lastName = $dbUser[0]["last_name"];
        $password = $dbUser[0]["password"];

        $stmt = $this->connect()->prepare('INSERT INTO user(first_name, last_name, mail, password, role_id_role, send_mail) VALUES(?, ?, ?, ?, ?, ?);');

        if(!$stmt->execute(array($firstName, $lastName, $mail, $password, 1, 1))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        $stmt = $this->connect()->prepare('DELETE FROM unverified_user WHERE mail = ?;');

        if(!$stmt->execute(array($mail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>