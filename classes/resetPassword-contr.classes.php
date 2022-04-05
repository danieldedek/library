<?php

class ResetPasswordContr extends ResetPassword {

    private $pwdResetSelector;
    private $pwdResetExpires;
    private $validator;
    private $password;

    public function __construct($pwdResetSelector, $pwdResetExpires, $validator, $password) {
        $this->pwdResetSelector = $pwdResetSelector;
        $this->pwdResetExpires = $pwdResetExpires;
        $this->validator = $validator;
        $this->password = $password;
    }

    public function verifyReset() {
        return $this->selectReset($this->pwdResetSelector, $this->pwdResetExpires, $this->validator, $this->password);
    }
}
?>