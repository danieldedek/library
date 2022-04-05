<?php

class UpdateSellerContr extends UpdateSeller {
    
    private $newSeller;
    private $oldSeller;
    private $wrongInputs;

    public function __construct($newSeller, $oldSeller) {
        $this->newSeller = $newSeller;
        $this->oldSeller = $oldSeller;
        $this->wrongInputs = array();
    }

    public function updateSeller() {
        if($this->invalidSeller() == false)
            array_push($this->wrongInputs, "Jméno prodejce musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->sellerDoesNotExist() == true)
            array_push($this->wrongInputs, "Tento prodejce neexistuje");
        if($this->sellerAlreadyAdded() == false)
            array_push($this->wrongInputs, "Tento prodejce již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setSeller($this->oldSeller, $this->newSeller);
        echo '<div class="wrapper"><p>Úprava prodejce proběhla úspěšně</p></div>';
    }

    private function invalidSeller() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newSeller))
            return false;
        return true;
    }

    private function sellerDoesNotExist() {
        if($this->checkPublisher($this->oldSeller))
            return false;
        return true;
    }

    private function sellerAlreadyAdded() {
        if($this->checkPublisher($this->newSeller))
            return false;
        return true;
    }
}
?>