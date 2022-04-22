<?php

class AllImperfectionsContr extends AllImperfections {

    private $sort;

    public function __construct($sort) {
        $this->sort = $sort;
    }

    public function showAllImperfections() {
        $this->getAllImperfections($this->sort);
    }
}
?>