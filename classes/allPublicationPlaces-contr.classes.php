<?php

class AllPublicationPlacesContr extends AllPublicationPlaces {

    private $sort;

    public function __construct($sort) {
        $this->sort = $sort;
    }

    public function showAllPublicationPlaces() {
        $this->getAllPublicationPlaces($this->sort);
    }
}
?>