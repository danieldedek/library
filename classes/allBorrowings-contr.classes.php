<?php

class AllBorrowingsContr extends AllBorrowings {

    private $order;
    private $sort;

    public function __construct($order, $sort) {
        $this->order = $order;
        $this->sort = $sort;
    }

    public function showAllBorrowings() {
        $this->getAllBorrowings($this->order, $this->sort);
    }
}
?>