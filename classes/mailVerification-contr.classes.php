<?php

class MailVerificationContr extends MailVerification {
    
    private $verificationCode;
    private $mail;

    public function __construct($verificationCode, $mail) {
        $this->verificationCode = $verificationCode;
        $this->mail = $mail;
    }

    public function mailVerification() {
        if($this->verifyMail() == false) {
            echo ("Neplatný kód");
            return;
        }
        $this->addToUser($this->verificationCode, $this->mail);
        echo '<div class="wrapper"><p>Ověření mailu proběhlo úspěšně</p></div>';
    }

    private function verifyMail() {
        if(!$this->verify($this->verificationCode, $this->mail))
            return false;
        return true;
    }
}
?>