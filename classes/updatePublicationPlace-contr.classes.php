<?php

class UpdatePublicationPlaceContr extends UpdatePublicationPlace {
    
    private $newPublicationPlace;
    private $oldPublicationPlace;
    private $wrongInputs;

    public function __construct($newPublicationPlace, $oldPublicationPlace) {
        $this->newPublicationPlace = $newPublicationPlace;
        $this->oldPublicationPlace = $oldPublicationPlace;
        $this->wrongInputs = array();
    }

    public function updatePublicationPlace() {
        if($this->invalidPublicationPlace() == false)
            array_push($this->wrongInputs, "Jméno vydavatelství musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->publicationPlaceDoesNotExist() == true)
            array_push($this->wrongInputs, "Toto místo vydání neexistuje");
        if($this->publicationPlaceAlreadyAdded() == false)
            array_push($this->wrongInputs, "Toto místo vydání již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setPublicationPlace($this->oldPublicationPlace, $this->newPublicationPlace);
        echo '<div class="wrapper"><p>Úprava místa vydání proběhla úspěšně</p></div>';
    }

    private function invalidPublicationPlace() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newPublicationPlace))
            return false;
        return true;
    }

    private function publicationPlaceDoesNotExist() {
        if($this->checkPublicationPlace($this->oldPublicationPlace))
            return false;
        return true;
    }

    private function publicationPlaceAlreadyAdded() {
        if($this->checkPublicationPlace($this->newPublicationPlace))
            return false;
        return true;
    }
}
?>