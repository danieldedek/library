<?php

class SetImperfectionsContr extends SetImperfections {

    private $oldISBN;

    public function __construct($oldISBN) {
        $this->oldISBN = $oldISBN;
    }

    public function setImperfections() {
        return $this->getImperfections($this->oldISBN);
    }
}
?>