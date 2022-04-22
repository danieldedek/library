<?php

class AllPublishersContr extends AllPublishers {

    private $sort;

    public function __construct($sort) {
        $this->sort = $sort;
    }

    public function showAllPublishers() {
        $this->getAllPublishers($this->sort);
    }
}
?>