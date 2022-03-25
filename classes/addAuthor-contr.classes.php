<?php

class AddAuthorContr extends AddAuthor {
    
    private $name;
    private $wrongInputs;

    public function __construct($name) {
        $this->name = $name;
        $this->wrongInputs = array();
    }

    public function addAuthor() {
        if($this->invalidName() == false)
            array_push($this->wrongInputs, "Jméno autora musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->authorAlreadyAdded() == false)
            array_push($this->wrongInputs, "Autor s tímto jménem už byl přidán");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setAuthor($this->name);
        echo '<div class="wrapper"><p>Přidání autora proběhlo úspěšně</p></div>';
    }

    private function invalidName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->name))
            return false;
        return true;
    }

    private function authorAlreadyAdded() {
        if(!$this->checkAuthor($this->name))
            return false;
        return true;
    }
}
?>