<?php

class UpdateImperfectionContr extends UpdateImperfection {
    
    private $newImperfection;
    private $oldImperfection;
    private $wrongInputs;

    public function __construct($newImperfection, $oldImperfection) {
        $this->newImperfection = $newImperfection;
        $this->oldImperfection = $oldImperfection;
        $this->wrongInputs = array();
    }

    public function updateImperfection() {
        if($this->invalidImperfection() == false)
            array_push($this->wrongInputs, "Název závady musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->imperfectionDoesNotExist() == true)
            array_push($this->wrongInputs, "Tuto závadu nelze upravit");
        if($this->imperfectionAlreadyAdded() == false)
            array_push($this->wrongInputs, "Tato závada již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setImperfection($this->oldImperfection, $this->newImperfection);
        echo '<div class="wrapper"><p>Úprava závady proběhla úspěšně</p></div>';
    }

    private function invalidImperfection() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newImperfection))
            return false;
        return true;
    }

    private function imperfectionDoesNotExist() {
        if($this->checkImperfection($this->oldImperfection))
            return false;
        return true;
    }

    private function imperfectionAlreadyAdded() {
        if($this->checkImperfection($this->newImperfection))
            return false;
        return true;
    }
}
?>