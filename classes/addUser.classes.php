<?php

class AddUser extends DatabaseHandler {

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

    protected function setUser($firstName, $lastName, $mail, $password, $role) {
        $stmt = $this->connect()->prepare('SELECT id_role FROM role WHERE name = ?;');

        if(!$stmt->execute(array($role))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        $dbRole = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $idRole = $dbRole[0]["id_role"];

        $stmt = $this->connect()->prepare('INSERT INTO user(first_name, last_name, mail, password, role_id_role, send_mail) VALUES(?, ?, ?, ?, ?, ?);');

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if(!$stmt->execute(array($firstName, $lastName, $mail, $hashedPassword, $idRole, '1'))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>