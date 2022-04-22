<?php

class AllPublicationPlacesSearchContr extends AllPublicationPlacesSearch {

    private $publicationPlace;

    public function __construct($publicationPlace) {
        $this->publicationPlace = $publicationPlace;
    }

    public function showAllPublicationPlaces() {
        $this->getAllPublicationPlaces($this->publicationPlace);
    }

    public function showAllPublicationPlacesHelp() {
        $this->getAllPublicationPlacesHelp($this->publicationPlace);
    }
}
?>