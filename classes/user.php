<?php

class User {
    
    private $idUser;
    private $firstName;
    private $keyName;
    private $mail;
    private $role;
    private $sendMail;

    public function __construct($idUser, $firstName, $keyName, $mail, $role, $sendMail) {
        $this->idUser = $idUser;
        $this->firstName = $firstName;
        $this->keyName = $keyName;
        $this->mail = $mail;
        $this->role = $role;
        $this->sendMail = $sendMail;
    }

    public function getIdUser() {
        return $this->idUser;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getKeyName() {
        return $this->keyName;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getRole() {
        return $this->role;
    }

    public function getSendMail() {
        return $this->sendMail;
    }
}
?>