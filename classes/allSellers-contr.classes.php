<?php

class AllSellersContr extends AllSellers {

    private $sort;

    public function __construct($sort) {
        $this->sort = $sort;
    }

    public function showAllSellers() {
        $this->getAllSellers($this->sort);
    }
}
?>