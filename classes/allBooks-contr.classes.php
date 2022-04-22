<?php

class AllBooksContr extends AllBooks {

    private $order;
    private $sort;

    public function __construct($order, $sort) {
        $this->order = $order;
        $this->sort = $sort;
    }

    public function showAllBooks() {
        $this->getAllBooks($this->order, $this->sort);
    }
}
?>