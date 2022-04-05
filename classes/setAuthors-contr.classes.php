<?php

class SetAuthorsContr extends SetAuthors {

    private $oldISBN;

    public function __construct($oldISBN) {
        $this->oldISBN = $oldISBN;
    }

    public function setAuthors() {
        return $this->getAuthors($this->oldISBN);
    }
}
?>