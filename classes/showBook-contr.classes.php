<?php

class ShowBookContr extends ShowBook {

    private $ISBN;

    public function __construct($ISBN) {
        $this->ISBN = $ISBN;
    }

    public function showBook() {
        if($this->ISBNDoesNotExist() == false)
            echo ("Tuto knihu nelze vypsat");
        $this->getBook($this->ISBN);
    }

    private function ISBNDoesNotExist() {
        if($this->checkISBN($this->ISBN))
            return false;
        return true;
    }
}
?>