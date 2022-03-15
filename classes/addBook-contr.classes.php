<?php

class AddBookContr extends AddBook {
    
    private $namesBeforeKey;
    private $prefixToKey;
    private $keyName;
    private $namesAfterKey;
    private $suffixToKey;
    private $bookName;
    private $publicationDate;
    private $ISBN;
    private $imperfection;
    private $publisherName;
    private $wrongInputs;

    public function __construct($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey, $bookName, $publicationDate, $ISBN, $imperfection, $publisherName) {
        $this->namesBeforeKey = $namesBeforeKey;
        $this->prefixToKey = $prefixToKey;
        $this->keyName = $keyName;
        $this->namesAfterKey = $namesAfterKey;
        $this->suffixToKey = $suffixToKey;
        $this->bookName = $bookName;
        $this->publicationDate = $publicationDate;
        $this->ISBN = $ISBN;
        $this->imperfection = $imperfection;
        $this->publisherName = $publisherName;
        $this->wrongInputs = array();
    }

    public function addBook() {
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
        if($this->invalidBookName() == false)
            array_push($this->wrongInputs, "Název knihy musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidPublicationDate() == false)
            array_push($this->wrongInputs, "Rok vydání");
        if($this->invalidISBN() == false)
            array_push($this->wrongInputs, "ISBN");
        if($this->invalidImperfection() == false)
            array_push($this->wrongInputs, "Název závady musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidPublisherName() == false)
            array_push($this->wrongInputs, "Jméno vydavatele musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->bookAlreadyAdded() == false)
            array_push($this->wrongInputs, "Tento druh poškození již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setBook($this->namesBeforeKey, $this->prefixToKey, $this->keyName, $this->namesAfterKey, $this->suffixToKey, $this->bookName, $this->publicationDate, $this->ISBN, $this->imperfection, $this->publisherName);
        echo '<div class="wrapper"><p>Přidání knihy proběhlo úspěšně</p></div>';
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

    private function invalidBookName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[a-záčďéěíňóřšťúůýž]+)?$/mu", $this->bookName))
            return false;
        return true;
    }

    private function invalidPublicationDate() {
        if(!preg_match("/^[0-9]{4}$/mu", $this->publicationDate))
            return false;
        return true;
    }
    private function invalidISBN() {
        if(!preg_match("/^[0-9]{13}$/mu", $this->ISBN))
            return false;
        return true;
    }
    private function invalidImperfection() {
        if(preg_match("/^$/mu", $this->imperfection)) {
            $this->imperfection = NULL;
            return true;
        }
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->imperfection))
            return false;
        return true;
    }
    private function invalidPublisherName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->publisherName))
            return false;
        return true;
    }

    private function bookAlreadyAdded() {
        if(!$this->checkBook($this->namesBeforeKey, $this->prefixToKey, $this->keyName, $this->namesAfterKey, $this->suffixToKey, $this->bookName, $this->publicationDate, $this->ISBN, $this->imperfection, $this->publisherName))
            return false;
        return true;
    }
}
?>