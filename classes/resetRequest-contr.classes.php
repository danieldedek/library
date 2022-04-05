<?php

class ResetRequestContr extends ResetRequest {
    
    private $pwdReserMail;
    private $pwdResetSelector;
    private $pwdResetToken;
    private $pwdResetExpires;

    public function __construct($pwdReserMail, $pwdResetSelector, $pwdResetToken, $pwdResetExpires) {
        $this->pwdReserMail = $pwdReserMail;
        $this->pwdResetSelector = $pwdResetSelector;
        $this->pwdResetToken = $pwdResetToken;
        $this->pwdResetExpires = $pwdResetExpires;
        $this->wrongInputs = array();
    }

    public function addResetRequest() {
        if($this->mailDoesNotExist() == true) {
            echo '<div class="wrapper"><p>Uživatel s tímto mailem neexistuje</p></div>';
            return;
        }
        $this->setResetRequest($this->pwdReserMail, $this->pwdResetSelector, $this->pwdResetToken, $this->pwdResetExpires);
    }

    public function deleteResetRequest() {
        if($this->mailDoesNotExist() == true) {
            echo '<div class="wrapper"><p>Uživatel s tímto mailem neexistuje</p></div>';
            return;
        }
        $this->delResetRequest($this->pwdReserMail);
    }

    private function mailDoesNotExist() {
        if(!$this->checkMail($this->pwdReserMail))
            return false;
        return true;
    }
}
?>