<?php

class AllLastingBorrowingsContr extends AllLastingBorrowings {

    private $order;
    private $sort;

    public function __construct($order, $sort) {
        $this->order = $order;
        $this->sort = $sort;
    }

    public function showAllLastingBorrowings() {
        $this->getAllLastingBorrowings($this->order, $this->sort);
    }
}
?>