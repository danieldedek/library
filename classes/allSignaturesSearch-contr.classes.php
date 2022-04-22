<?php

class AllSignaturesSearchContr extends AllSignaturesSearch {

    private $signature;

    public function __construct($signature) {
        $this->signature = $signature;
    }

    public function showAllSignatures() {
        $this->getAllSignatures($this->signature);
    }

    public function showAllSignaturesHelp() {
        $this->getAllSignaturesHelp($this->signature);
    }
}
?>