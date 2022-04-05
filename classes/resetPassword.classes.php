<?php

class ResetPassword extends DatabaseHandler {

    protected function selectReset($pwdResetSelector, $pwdResetExpires, $validator, $password) {
        $stmt = $this->connect()->prepare('SELECT * FROM pwdReset WHERE pwdResetSelector = ? AND pwdResetExpires >= ?;');
        if(!$stmt->execute(array($pwdResetSelector, $pwdResetExpires))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Časový limit pro obnovení hesla vypršel, zažádejte znovu</p></div>';
            exit();
        }

        $dbToken = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $dbToken[0]["pwdResetToken"]);

        if($tokenCheck === false) {
            echo '<div class="wrapper"><p>Časový limit pro obnovení hesla vypršel, zažádejte znovu</p></div>';
            exit();
        }

        elseif($tokenCheck === true) {
            $tokenMail = $dbToken[0]["pwdResetMail"];

            $stmt = $this->connect()->prepare('SELECT * FROM user WHERE mail = ?;');
            if(!$stmt->execute(array($tokenMail))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                echo '<div class="wrapper"><p>Došlo k chybě</p></div>';
                exit();
            }

            else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $this->connect()->prepare('UPDATE user SET password = ? WHERE mail = ?;');
                if(!$stmt->execute(array($hashedPassword, $tokenMail))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }

                $stmt = $this->connect()->prepare('DELETE FROM pwdReset WHERE pwdResetMail = ?;');
                if(!$stmt->execute(array($tokenMail))) {
                    $stmt = null;
                    echo '<div class="wrapper"><p>stmt failed</p></div>';
                    exit();
                }
                header("Location: ../logIn.php?newPassword=passwordUpdated");
            }
        }
    }
}
?>