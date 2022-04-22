<?php

class AllImperfectionsSearchContr extends AllImperfectionsSearch {

    private $imperfection;

    public function __construct($imperfection) {
        $this->imperfection = $imperfection;
    }

    public function showAllImperfections() {
        $this->getAllImperfections($this->imperfection);
    }

    public function showAllImperfectionsHelp() {
        $this->getAllImperfectionsHelp($this->imperfection);
    }
}
?>