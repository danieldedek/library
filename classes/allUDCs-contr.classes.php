<?php

class AllUDCsContr extends AllUDCs {

    private $sort;

    public function __construct($sort) {
        $this->sort = $sort;
    }

    public function showAllUDCs() {
        $this->getAllUDCs($this->sort);
    }
}
?>