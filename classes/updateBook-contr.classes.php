<?php

class UpdateBookContr extends UpdateBook {
    
    private $newAuthorNames;
    private $newBookName;
    private $newPublicationYear;
    private $newISBN;
    private $newRegistrationNumber;
    private $newImperfections;
    private $newPublisherName;
    private $oldISBN;
    private $oldRegistrationNumber;
    private $wrongInputs;

    public function __construct($newAuthorNames, $newBookName, $newPublicationYear, $newISBN, $newRegistrationNumber, $newImperfections, $newPublisherName, $oldISBN, $oldRegistrationNumber) {
        $this->newAuthorNames = $newAuthorNames;
        $this->newBookName = $newBookName;
        $this->newPublicationYear = $newPublicationYear;
        $this->newISBN = $newISBN;
        $this->newRegistrationNumber = $newRegistrationNumber;
        $this->newImperfections = $newImperfections;
        $this->newPublisherName = $newPublisherName;
        $this->oldISBN = $oldISBN;
        $this->oldRegistrationNumber = $oldRegistrationNumber;
        $this->wrongInputs = array();
    }

    public function updateBook() {
        if($this->invalidAuthorName() == false)
            array_push($this->wrongInputs, "Jméno autora musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidBookName() == false)
            array_push($this->wrongInputs, "Název knihy musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidPublicationYear() == false)
            array_push($this->wrongInputs, "Rok vydání");
        if($this->invalidISBN() == false)
            array_push($this->wrongInputs, "ISBN");
        if($this->invalidRegistrationNumber() == false)
            array_push($this->wrongInputs, "Registrační číslo");
        if($this->invalidImperfection() == false)
            array_push($this->wrongInputs, "Název závady musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidPublisherName() == false)
            array_push($this->wrongInputs, "Jméno vydavatele musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->ISBNDoesNotExist() == true)
            array_push($this->wrongInputs, "Tuto knihu nelze upravit");
        if($this->ISBNAlreadyExists() == false)
            array_push($this->wrongInputs, "Kniha s tímto ISBN již je v databázi");
        if($this->registrationNumberDoesNotExist() == true)
            array_push($this->wrongInputs, "Tuto knihu nelze upravit");
        if($this->registrationNumberAlreadyExists() == false)
            array_push($this->wrongInputs, "Kniha s tímto registračním číslem již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setBook($this->oldISBN, $this->oldRegistrationNumber, $this->newAuthorNames, $this->newBookName, $this->newPublicationYear, $this->newISBN, $this->newRegistrationNumber, $this->newImperfections, $this->newPublisherName));
        echo '<div class="wrapper"><p>Přidání knihy proběhlo úspěšně</p></div>';
    }

    private function invalidAuthorName() {
        $valid = true;
        foreach ($this->newAuthorNames as $authorName) {
            if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $authorName))
                $valid = false;
        }
        return $valid;
    }

    private function invalidBookName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newBookName))
            return false;
        return true;
    }

    private function invalidPublicationYear() {
        if(!preg_match("/^[0-9]{4}$/mu", $this->newPublicationYear))
            return false;
        return true;
    }

    private function invalidISBN() {
        if(!preg_match("/^[0-9]{13}$/mu", $this->newISBN))
            return false;
        return true;
    }

    private function invalidRegistrationNumber() {
        if(!preg_match("/^[0-9]{5}$/mu", $this->newRegistrationNumber))
            return false;
        return true;
    }

    private function invalidImperfection() {
        $valid = true;
        foreach ($this->newImperfections as $imperfection) {
            if(preg_match("/^$/mu", $imperfection)) {
                $imperfection = "NULL";
            }
            if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $imperfection))
                $valid = false;
        }
        return $valid;
    }

    private function invalidPublisherName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newPublisherName))
            return false;
        return true;
    }

    private function ISBNDoesNotExist() {
        if($this->checkISBN($this->oldISBN))
            return false;
        return true;
    }

    private function ISBNAlreadyExists() {
        if(!$this->checkISBN($this->newISBN))
            return false;
        return true;
    }

    private function registrationNumberDoesNotExist() {
        if($this->checkRegistrationNumber($this->oldRegistrationNumber))
            return false;
        return true;
    }

    private function registrationNumberAlreadyExists() {
        if(!$this->checkRegistrationNumber($this->newRegistrationNumber))
            return false;
        return true;
    }
}
?>