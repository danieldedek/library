<?php

class ResetRequest extends DatabaseHandler {

    protected function checkMail($pwdResetMail) {
        $stmt = $this->connect()->prepare('SELECT mail FROM user WHERE mail = ?;');
        if(!$stmt->execute(array($pwdResetMail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function delResetRequest($pwdResetMail) {
        $stmt = $this->connect()->prepare('DELETE FROM pwdReset WHERE pwdResetMail = ?;');
        if(!$stmt->execute(array($pwdResetMail))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
    }

    protected function setResetRequest($pwdResetMail, $pwdResetSelector, $pwdResetToken, $pwdResetExpires) {
        $stmt = $this->connect()->prepare('INSERT INTO pwdReset(pwdResetMail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);');
        if(!$stmt->execute(array($pwdResetMail, $pwdResetSelector, $pwdResetToken, $pwdResetExpires))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
    }
}
?>