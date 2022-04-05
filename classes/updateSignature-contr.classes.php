<?php

class UpdateSignatureContr extends UpdateSignature {
    
    private $newSignature;
    private $oldSignature;
    private $wrongInputs;

    public function __construct($newSignature, $oldSignature) {
        $this->newSignature = $newSignature;
        $this->oldSignature = $oldSignature;
        $this->wrongInputs = array();
    }

    public function updateSignature() {
        if($this->invalidSignature() == false)
            array_push($this->wrongInputs, "Signatura musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->signatureDoesNotExist() == true)
            array_push($this->wrongInputs, "Tato signatura neexistuje");
        if($this->signatureAlreadyAdded() == false)
            array_push($this->wrongInputs, "Tato signatura již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setSignature($this->oldSignature, $this->newSignature);
        echo '<div class="wrapper"><p>Úprava vydavatele proběhla úspěšně</p></div>';
    }

    private function invalidSignature() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newSignature))
            return false;
        return true;
    }

    private function signatureDoesNotExist() {
        if($this->checkSignature($this->oldSignature))
            return false;
        return true;
    }

    private function signatureAlreadyAdded() {
        if($this->checkSignature($this->newSignature))
            return false;
        return true;
    }
}
?>