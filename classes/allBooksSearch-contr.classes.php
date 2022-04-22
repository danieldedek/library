<?php

class AllBooksSearchContr extends AllBooksSearch {

    private $book;
    private $ISBN;
    private $incrementalNumber;
    private $UDC;

    public function __construct($book, $ISBN, $incrementalNumber, $UDC) {
        $this->book = $book;
        $this->ISBN = $ISBN;
        $this->incrementalNumber = $incrementalNumber;
        $this->UDC = $UDC;
    }

    public function showAllBooks() {
        $this->getAllBooks($this->book, $this->ISBN, $this->incrementalNumber, $this->UDC);
    }

    public function showAllBooksHelp() {
        $this->getAllBooksHelp($this->book, $this->ISBN, $this->incrementalNumber, $this->UDC);
    }
}
?>