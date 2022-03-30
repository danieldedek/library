<?php

class UpdateAuthorContr extends UpdateAuthor {
    
    private $newName;
    private $oldName;
    private $wrongInputs;

    public function __construct($newName, $oldName) {
        $this->newName = $newName;
        $this->oldName = $oldName;
        $this->wrongInputs = array();
    }

    public function updateAuthor() {
        if($this->invalidName() == false)
            array_push($this->wrongInputs, "Jméno autora musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->authorDoesNotExist() == true)
            array_push($this->wrongInputs, "Tohoto autora nelze upravit");
        if($this->authorAlreadyAdded() == false)
            array_push($this->wrongInputs, "Tento autor již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setAuthor($this->oldName, $this->newName);
        echo '<div class="wrapper"><p>Úprava autora proběhla úspěšně</p></div>';
    }

    private function invalidName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newName))
            return false;
        return true;
    }

    private function authorDoesNotExist() {
        if($this->checkAuthor($this->oldName))
            return false;
        return true;
    }

    private function authorAlreadyAdded() {
        if($this->checkAuthor($this->newName))
            return false;
        return true;
    }
}
?>