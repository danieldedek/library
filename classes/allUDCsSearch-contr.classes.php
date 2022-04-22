<?php

class AllUDCsSearchContr extends AllUDCsSearch {

    private $UDC;

    public function __construct($UDC) {
        $this->UDC = $UDC;
    }

    public function showAllUDCs() {
        $this->getAllUDCs($this->UDC);
    }

    public function showAllUDCsHelp() {
        $this->getAllUDCsHelp($this->UDC);
    }
}
?>