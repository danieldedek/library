<?php

class AddPublisherContr extends AddPublisher {
    
    private $publisherName;
    private $wrongInputs;

    public function __construct($publisherName) {
        $this->publisherName = $publisherName;
        $this->wrongInputs = array();
    }

    public function addPublisher() {
        if($this->invalidPublisherName() == false)
            array_push($this->wrongInputs, "Jméno vydavatelství musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
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
        $this->setPublisher($this->publisherName);
        echo '<div class="wrapper"><p>Přidání vydavatele proběhlo úspěšně</p></div>';
    }

    private function invalidPublisherName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->publisherName))
            return false;
        return true;
    }

    private function publisherAlreadyAdded() {
        if(!$this->checkPublisher($this->publisherName))
            return false;
        return true;
    }
}
?>