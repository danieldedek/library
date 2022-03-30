<?php

class UpdatePublisherContr extends UpdatePublisher {
    
    private $newPublisher;
    private $oldPublisher;
    private $wrongInputs;

    public function __construct($newPublisher, $oldPublisher) {
        $this->newPublisher = $newPublisher;
        $this->oldPublisher = $oldPublisher;
        $this->wrongInputs = array();
    }

    public function updatePublisher() {
        if($this->invalidPublisherName() == false)
            array_push($this->wrongInputs, "Jméno vydavatelství musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->publisherDoesNotExist() == true)
            array_push($this->wrongInputs, "Tohoto vydavatele nelze upravit");
        if($this->publisherAlreadyAdded() == false)
            array_push($this->wrongInputs, "Tento vydavatel již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setPublisher($this->oldPublisher, $this->newPublisher);
        echo '<div class="wrapper"><p>Úprava vydavatele proběhla úspěšně</p></div>';
    }

    private function invalidPublisherName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newPublisher))
            return false;
        return true;
    }

    private function publisherDoesNotExist() {
        if($this->checkPublisher($this->oldPublisher))
            return false;
        return true;
    }

    private function publisherAlreadyAdded() {
        if($this->checkPublisher($this->newPublisher))
            return false;
        return true;
    }
}
?>