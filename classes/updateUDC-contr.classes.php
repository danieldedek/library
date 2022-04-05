<?php

class UpdateUDCContr extends UpdateUDC {
    
    private $newUDC;
    private $oldUDC;
    private $wrongInputs;

    public function __construct($newUDC, $oldUDC) {
        $this->newUDC = $newUDC;
        $this->oldUDC = $oldUDC;
        $this->wrongInputs = array();
    }

    public function updateUDC() {
        if($this->invalidUDC() == false)
            array_push($this->wrongInputs, "Mezinárodní desetinné třídění musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->UDCDoesNotExist() == true)
            array_push($this->wrongInputs, "Toto mezinárodní desetinné třídění neexistuje");
        if($this->UDCAlreadyAdded() == false)
            array_push($this->wrongInputs, "Toto mezinárodní desetinné třídění již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setUDC($this->oldUDC, $this->newUDC);
        echo '<div class="wrapper"><p>Úprava mezinárodního desetinného třídění  proběhla úspěšně</p></div>';
    }

    private function invalidUDC() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newUDC))
            return false;
        return true;
    }

    private function UDCDoesNotExist() {
        if($this->checkUDC($this->oldUDC))
            return false;
        return true;
    }

    private function UDCAlreadyAdded() {
        if($this->checkUDC($this->newUDC))
            return false;
        return true;
    }
}
?>