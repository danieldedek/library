<?php

class AllAuthorsContr extends AllAuthors {

    private $sort;

    public function __construct($sort) {
        $this->sort = $sort;
    }

    public function showAllAuthors() {
        $this->getAllAuthors($this->sort);
    }
}
?>