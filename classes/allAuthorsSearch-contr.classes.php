<?php

class AllAuthorsSearchContr extends AllAuthorsSearch {

    private $authorName;

    public function __construct($authorName) {
        $this->authorName = $authorName;
    }

    public function showAllAuthors() {
        $this->getAllAuthors($this->authorName);
    }

    public function showAllAuthorsHelp() {
        $this->getAllAuthorsHelp($this->authorName);
    }
}
?>