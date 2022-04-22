<?php

class AllSignaturesContr extends AllSignatures {

    private $sort;

    public function __construct($sort) {
        $this->sort = $sort;
    }

    public function showAllSignatures() {
        $this->getAllSignatures($this->sort);
    }
}
?>