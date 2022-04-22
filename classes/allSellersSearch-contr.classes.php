<?php

class AllSellersSearchContr extends AllSellersSearch {

    private $seller;

    public function __construct($seller) {
        $this->seller = $seller;
    }

    public function showAllSellers() {
        $this->getAllSellers($this->seller);
    }

    public function showAllSellersHelp() {
        $this->getAllSellersHelp($this->seller);
    }
}
?>