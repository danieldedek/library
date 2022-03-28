<?php

class AddBookContr extends AddBook {
    
    private $authorNames;
    private $bookName;
    private $publicationYear;
    private $ISBN;
    private $registrationNumber;
    private $imperfections;
    private $publisherName;
    private $wrongInputs;

    public function __construct($authorNames, $bookName, $publicationYear, $ISBN, $registrationNumber, $imperfections, $publisherName) {
        $this->authorNames = $authorNames;
        $this->bookName = $bookName;
        $this->publicationYear = $publicationYear;
        $this->ISBN = $ISBN;
        $this->registrationNumber = $registrationNumber;
        $this->imperfections = $imperfections;
        $this->publisherName = $publisherName;
        $this->wrongInputs = array();
    }

    public function addBook() {
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
        if($this->ISBNAlreadyExists() == false)
            array_push($this->wrongInputs, "Kniha s tímto ISBN již je v databázi");
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
        $this->setBook($this->authorNames, $this->bookName, $this->publicationYear, $this->ISBN, $this->registrationNumber, $this->imperfections, $this->publisherName);
        echo '<div class="wrapper"><p>Přidání knihy proběhlo úspěšně</p></div>';
    }

    private function invalidAuthorName() {
        $valid = true;
        foreach ($this->authorNames as $authorName) {
            if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $authorName))
                $valid = false;
        }
        return $valid;
    }

    private function invalidBookName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[a-záčďéěíňóřšťúůýž]+)?$/mu", $this->bookName))
            return false;
        return true;
    }

    private function invalidPublicationYear() {
        if(!preg_match("/^[0-9]{4}$/mu", $this->publicationYear))
            return false;
        return true;
    }

    private function invalidISBN() {
        if(!preg_match("/^[0-9]{13}$/mu", $this->ISBN))
            return false;
        return true;
    }

    private function invalidRegistrationNumber() {
        if(!preg_match("/^[0-9]{5}$/mu", $this->registrationNumber))
            return false;
        return true;
    }

    private function invalidImperfection() {
        $valid = true;
        foreach ($this->imperfections as $imperfection) {
            if(preg_match("/^$/mu", $imperfection)) {
                $imperfection = "NULL";
            }
            if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $imperfection))
                $valid = false;
        }
        return $valid;
    }

    private function invalidPublisherName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->publisherName))
            return false;
        return true;
    }

    private function ISBNAlreadyExists() {
        if(!$this->checkISBN($this->ISBN))
            return false;
        return true;
    }

    private function registrationNumberAlreadyExists() {
        if(!$this->checkRegistrationNumber($this->registrationNumber))
            return false;
        return true;
    }
}
?>