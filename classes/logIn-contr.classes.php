<?php

class LogInContr extends LogIn {
    
    private $mail;
    private $password;

    public function __construct($mail, $password) {
        $this->mail = $mail;
        $this->password = $password;
    }

    public function logInUser() {
        $this->getUser($this->mail, $this->password);
    }
}
?>