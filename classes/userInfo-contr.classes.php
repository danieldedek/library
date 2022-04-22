<?php

class UserInfoContr extends UserInfo {
    
    private $idUser;
    private $sendMail;

    public function __construct($idUser, $sendMail) {
        $this->idUser = $idUser;
        $this->sendMail = $sendMail;
    }

    public function showBorrowedBooks() {
        $this->getBorrowedBooks($this->idUser);
        $this->getBorrowingHistory($this->idUser);
    }

    public function changeSendMail() {
        $this->setSendMail($this->sendMail);
    }
}
?>