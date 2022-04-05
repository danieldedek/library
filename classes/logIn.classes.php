<?php

class LogIn extends DatabaseHandler {

    protected function getUser($mail, $password) {

        $stmt = $this->connect()->prepare('SELECT * FROM user WHERE mail = ?;');

        if(!$stmt->execute(array($mail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Špatné přihlašovací údaje</p></div>';
            return;
        }

        $dbUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $dbUser[0]["password"]);

        if($checkPassword == false) {
            $stmt = null;
            echo '<div class="wrapper"><p>Špatné přihlašovací údaje</p></div>';
            return;
        }

        $user = new User($dbUser[0]["id_user"], $dbUser[0]["first_name"], $dbUser[0]["last_name"], $dbUser[0]["mail"], $dbUser[0]["role_id_role"], $dbUser[0]["send_mail"]);
        $_SESSION['user'] = serialize($user);
        $stmt = null;
        header('Location: ./userInfo.php');
    }
}
?>