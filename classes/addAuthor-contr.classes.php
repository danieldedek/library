<?php

class AddAuthorContr extends AddAuthor {
    
    private $namesBeforeKey;
    private $prefixToKey;
    private $keyName;
    private $namesAfterKey;
    private $suffixToKey;
    private $wrongInputs;

    public function __construct($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey) {
        $this->namesBeforeKey = $namesBeforeKey;
        $this->prefixToKey = $prefixToKey;
        $this->keyName = $keyName;
        $this->namesAfterKey = $namesAfterKey;
        $this->suffixToKey = $suffixToKey;
        $this->wrongInputs = array();
    }

    public function addAuthor() {
        if($this->invalidNamesBeforeKey() == false)
            array_push($this->wrongInputs, "Names before key musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidPrefixToKey() == false)
            array_push($this->wrongInputs, "Prefix to key musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidKeyName() == false)
            array_push($this->wrongInputs, "Key name musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidNamesAfterKey() == false)
            array_push($this->wrongInputs, "Names after key musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidSuffixToKey() == false)
            array_push($this->wrongInputs, "Suffix to key musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
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
        $this->setAuthor($this->namesBeforeKey, $this->prefixToKey, $this->keyName, $this->namesAfterKey, $this->suffixToKey);
        echo '<div class="wrapper"><p>Přidání autora proběhlo úspěšně</p></div>';
    }

    private function invalidNamesBeforeKey() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->namesBeforeKey))
            return false;
        return true;
    }

    private function invalidPrefixToKey() {
        if(preg_match("/^$/mu", $this->prefixToKey)) {
            $this->prefixToKey = NULL;
            return true;
        }
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->prefixToKey))
            return false;
        return true;
    }

    private function invalidKeyName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->keyName))
            return false;
        return true;
    }

    private function invalidNamesAfterKey() {
        if(preg_match("/^$/mu", $this->namesAfterKey)) {
            $this->namesAfterKey = NULL;
            return true;
        }
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->namesAfterKey))
            return false;
        return true;
    }

    private function invalidSuffixToKey() {
        if(preg_match("/^$/mu", $this->suffixToKey)) {
            $this->suffixToKey = NULL;
            return true;
        }
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->suffixToKey))
            return false;
        return true;
    }

    private function authorAlreadyAdded() {
        if(!$this->checkAuthor($this->namesBeforeKey, $this->prefixToKey, $this->keyName, $this->namesAfterKey, $this->suffixToKey))
            return false;
        return true;
    }
}
?>