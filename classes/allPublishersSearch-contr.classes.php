<?php

class AllPublishersSearchContr extends AllPublishersSearch {

    private $publisher;

    public function __construct($publisher) {
        $this->publisher = $publisher;
    }

    public function showAllPublishers() {
        $this->getAllPublishers($this->publisher);
    }

    public function showAllPublishersHelp() {
        $this->getAllPublishersHelp($this->publisher);
    }
}
?>