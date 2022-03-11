<?php

class UserInfoContr extends UserInfo {
    
    private $idUser;

    public function __construct($idUser) {
        $this->idUser = $idUser;
    }

    public function showBorrowedBooks() {
        $this->getBorrowedBooks($this->idUser);
    }
}
?>