<?php

class UpdateUser extends DatabaseHandler {

    protected function checkUser($oldMail) {
        $stmt = $this->connect()->prepare('SELECT mail FROM user WHERE mail = ?;');

        if(!$stmt->execute(array($oldMail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return true;
        return false;
    }

    protected function setUser($oldMail, $newFirstName, $newLastName, $newMail, $newPassword, $newRole) {
        $stmt = $this->connect()->prepare('SELECT id_role FROM role WHERE name = ?;');

        if(!$stmt->execute(array($newRole))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        $dbRole = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $idRole = $dbRole[0]["id_role"];

        if($newPassword == "NULL") {
            $stmt = $this->connect()->prepare('UPDATE user SET first_name=?, last_name=?, mail=?, role_id_role=? WHERE mail=?;');

            if(!$stmt->execute(array($newFirstName, $newLastName, $newMail, $idRole, $oldMail))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
            
            $stmt = null;
            return;
        }

        $stmt = $this->connect()->prepare('UPDATE user SET first_name=?, last_name=?, mail=?, password=?, role_id_role=? WHERE mail=?;');

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        echo($newFirstName . " " . $newLastName . " " . $newMail . " " . $hashedPassword . " " . $idRole . " " . $oldMail);

        if(!$stmt->execute(array($newFirstName, $newLastName, $newMail, $hashedPassword, $idRole, $oldMail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}
?>