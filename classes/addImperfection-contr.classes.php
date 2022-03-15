<?php

class AddImperfectionContr extends AddImperfection {
    
    private $imperfection;
    private $wrongInputs;

    public function __construct($imperfection) {
        $this->imperfection = $imperfection;
        $this->wrongInputs = array();
    }

    public function addImperfection() {
        if($this->invalidImperfection() == false)
            array_push($this->wrongInputs, "Název závady musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->imperfectionAlreadyAdded() == false)
            array_push($this->wrongInputs, "Tento druh poškození již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setImperfection($this->imperfection);
        echo '<div class="wrapper"><p>Přidání závady proběhlo úspěšně</p></div>';
    }

    private function invalidImperfection() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->imperfection))
            return false;
        return true;
    }

    private function imperfectionAlreadyAdded() {
        if(!$this->checkImperfection($this->imperfection))
            return false;
        return true;
    }
}
?>