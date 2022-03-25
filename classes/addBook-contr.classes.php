<?php

class AddBookContr extends AddBook {
    
    private $authorName;
    private $bookName;
    private $publicationYear;
    private $ISBN;
    private $registrationNumber;
    private $imperfection;
    private $publisherName;
    private $wrongInputs;

    public function __construct($authorName, $bookName, $publicationYear, $ISBN, $registrationNumber, $imperfection, $publisherName) {
        $this->authorName = $authorName;
        $this->bookName = $bookName;
        $this->publicationYear = $publicationYear;
        $this->ISBN = $ISBN;
        $this->registrationNumber = $registrationNumber;
        $this->imperfection = $imperfection;
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
        if($this->bookAlreadyAdded() == false)
            array_push($this->wrongInputs, "Tato kniha již je v databázi");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setBook($this->authorName, $this->bookName, $this->publicationYear, $this->ISBN, $this->registrationNumber, $this->imperfection, $this->publisherName);
        echo '<div class="wrapper"><p>Přidání knihy proběhlo úspěšně</p></div>';
    }

    private function invalidAuthorName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->authorName))
            return false;
        return true;
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
        if(!$this->checkBook($this->authorName, $this->bookName, $this->publicationYear, $this->ISBN, $this->registrationNumber, $this->imperfection, $this->publisherName))
            return false;
        return true;
    }
}
?>