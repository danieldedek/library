<?php

class ResetRequestContr extends ResetRequest {
    
    private $pwdResetMail;
    private $pwdResetSelector;
    private $pwdResetToken;
    private $pwdResetExpires;

    public function __construct($pwdResetMail, $pwdResetSelector, $pwdResetToken, $pwdResetExpires) {
        $this->pwdResetMail = $pwdResetMail;
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
        $this->setResetRequest($this->pwdResetMail, $this->pwdResetSelector, $this->pwdResetToken, $this->pwdResetExpires);
    }

    public function deleteResetRequest() {
        if($this->mailDoesNotExist() == true) {
            echo '<div class="wrapper"><p>Uživatel s tímto mailem neexistuje</p></div>';
            return;
        }
        $this->delResetRequest($this->pwdResetMail);
    }

    private function mailDoesNotExist() {
        if(!$this->checkMail($this->pwdResetMail))
            return false;
        return true;
    }
}
?>