<?php

class UpdateBookContr extends UpdateBook {
    
    private $newAuthorNames;
    private $newBook;
    private $newIncrementalNumber;
    private $newAcquisitionDate;
    private $newPrice;
    private $newPurchaseDocument;
    private $newSeller;
    private $newPublicationYear;
    private $newPublicationPlace;
    private $newPublisher;
    private $newIssueNumber;
    private $newPageCount;
    private $newUDC;
    private $newSignature;
    private $newISBN;
    private $newImperfections;
    private $oldBook;
    private $oldSeller;
    private $oldPublicationPlace;
    private $oldPublisher;
    private $oldUDC;
    private $oldSignature;
    private $oldIncrementalNumber;
    private $oldIssueNumber;
    private $oldISBN;
    private $authors;
    private $imperfections;
    private $wrongInputs;

    public function __construct($newAuthorNames, $newBook, $newIncrementalNumber, $newAcquisitionDate, $newPrice, $newPurchaseDocument, $newSeller, $newPublicationYear, $newPublicationPlace, $newPublisher, $newIssueNumber, $newPageCount, $newUDC, $newSignature, $newISBN, $newImperfections, $oldBook, $oldSeller, $oldPublicationPlace, $oldPublisher, $oldUDC, $oldSignature, $oldIncrementalNumber, $oldIssueNumber, $oldISBN, $authors, $imperfections) {
        $this->newAuthorNames = $newAuthorNames;
        $this->newBook = $newBook;
        $this->newIncrementalNumber = $newIncrementalNumber;
        $this->newAcquisitionDate = $newAcquisitionDate;
        $this->newPrice = $newPrice;
        $this->newPurchaseDocument = $newPurchaseDocument;
        $this->newSeller = $newSeller;
        $this->newPublicationYear = $newPublicationYear;
        $this->newPublicationPlace = $newPublicationPlace;
        $this->newPublisher = $newPublisher;
        $this->newIssueNumber = $newIssueNumber;
        $this->newPageCount = $newPageCount;
        $this->newUDC = $newUDC;
        $this->newSignature = $newSignature;
        $this->newISBN = $newISBN;
        $this->newImperfections = $newImperfections;
        $this->oldBook = $oldBook;
        $this->oldSeller = $oldSeller;
        $this->oldPublicationPlace = $oldPublicationPlace;
        $this->oldPublisher = $oldPublisher;
        $this->oldUDC = $oldUDC;
        $this->oldSignature = $oldSignature;
        $this->oldIncrementalNumber = $oldIncrementalNumber;
        $this->oldIssueNumber = $oldIssueNumber;
        $this->oldISBN = $oldISBN;
        $this->authors = $authors;
        $this->imperfections = $imperfections;
        $this->wrongInputs = array();
    }

    public function updateBook() {
        if($this->invalidAuthorName() == false)
            array_push($this->wrongInputs, "Jméno autora musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidBook() == false)
            array_push($this->wrongInputs, "Název knihy musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidIncrementalNumber() == false)
            array_push($this->wrongInputs, "invalidIncrementalNumber");
        if($this->invalidAcquisitionDate() == false)
            array_push($this->wrongInputs, "invalidAcquisitionDate");
        if($this->invalidPrice() == false)
            array_push($this->wrongInputs, "invalidPrice");
        if($this->invalidPurchaseDocument() == false)
            array_push($this->wrongInputs, "invalidPurchaseDocument");
        if($this->invalidSeller() == false)
            array_push($this->wrongInputs, "invalidSeller");
        if($this->invalidPublicationYear() == false)
            array_push($this->wrongInputs, "invalidPublicationYear");
        if($this->invalidPublicationPlace() == false)
            array_push($this->wrongInputs, "invalidPublicationPlace");
        if($this->invalidPublisher() == false)
            array_push($this->wrongInputs, "invalidPublisher");
        if($this->invalidIssueNumberr() == false)
            array_push($this->wrongInputs, "invalidIssueNumberr");
        if($this->invalidPageCount() == false)
            array_push($this->wrongInputs, "invalidPageCount");
        if($this->invalidUDC() == false)
            array_push($this->wrongInputs, "UDC");
        if($this->invalidSignature() == false)
            array_push($this->wrongInputs, "invalidSignature");
        if($this->invalidISBN() == false)
            array_push($this->wrongInputs, "ISBN");
        if($this->invalidImperfection() == false)
            array_push($this->wrongInputs, "Název závady musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->incrementalNumberAlreadyExists() == false)
            array_push($this->wrongInputs, "Kniha s tímto incrementalNumberAlreadyExists již je v databázi");
        if($this->issueNumberAlreadyExists() == false)
            array_push($this->wrongInputs, "Kniha s tímto issueNumberAlreadyExists již je v databázi");
        if($this->ISBNAlreadyExists() == false)
            array_push($this->wrongInputs, "Kniha s tímto ISBN již je v databázi");
        if($this->ISBNDoesNotExist() == false)
            array_push($this->wrongInputs, "Tuto knihu nelze upravit");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setBook($this->newAuthorNames, $this->newBook, $this->newIncrementalNumber, $this->newAcquisitionDate, $this->newPrice, $this->newPurchaseDocument, $this->newSeller, $this->newPublicationYear, $this->newPublicationPlace, $this->newPublisher, $this->newIssueNumber, $this->newPageCount, $this->newUDC, $this->newSignature, $this->newISBN, $this->newImperfections, $this->oldBook, $this->oldSeller, $this->oldPublicationPlace, $this->oldPublisher, $this->oldUDC, $this->oldSignature, $this->oldISBN, $this->authors, $this->imperfections);
        echo '<div class="wrapper"><p>Úprava knihy proběhla úspěšně</p></div>';
    }

    private function invalidAuthorName() {
        $valid = true;
        foreach ($this->newAuthorNames as $authorName) {
            if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $authorName))
                $valid = false;
        }
        return $valid;
    }

    private function invalidBook() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->newBook))
            return false;
        return true;
    }

    private function invalidIncrementalNumber() {
        if(!preg_match("/^[0-9]{1,6}$/mu", $this->newIncrementalNumber))
            return false;
        return true;
    }

    private function invalidAcquisitionDate() {
        if(preg_match("/^$/mu", $this->newAcquisitionDate)) {
            $this->newAcquisitionDate = "NULL";
            return true;
        }
        if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/mu", $this->newAcquisitionDate))
            return false;
        return true;
    }

    private function invalidPrice() {
        if(!preg_match("/^[0-9]{1,6}$/mu", $this->newPrice))
            return false;
        return true;
    }

    private function invalidPurchaseDocument() {
        if(!preg_match("/^[0-9]{3,20}$/mu", $this->newPurchaseDocument))
            return false;
        return true;
    }

    private function invalidSeller() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->newSeller))
            return false;
        return true;
    }

    private function invalidPublicationYear() {
        if(!preg_match("/^[0-9]{4}$/mu", $this->newPublicationYear))
            return false;
        return true;
    }

    private function invalidPublicationPlace() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->newPublicationPlace))
            return false;
        return true;
    }

    private function invalidPublisher() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->newPublisher))
            return false;
        return true;
    }

    private function invalidIssueNumberr() {
        if(!preg_match("/^[0-9]{1,6}$/mu", $this->newIssueNumber))
            return false;
        return true;
    }
    
    private function invalidPageCount() {
        if(!preg_match("/^[0-9]{1,6}$/mu", $this->newPageCount))
            return false;
        return true;
    }

    private function invalidUDC() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->newUDC))
            return false;
        return true;
    }

    private function invalidSignature() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->newSignature))
            return false;
        return true;
    }

    private function invalidISBN() {
        if(!preg_match("/^[0-9]{13}$/mu", $this->newISBN))
            return false;
        return true;
    }

    private function invalidImperfection() {
        $valid = true;
        foreach ($this->newImperfections as $imperfection) {
            if(preg_match("/^$/mu", $imperfection)) {
                $imperfection = "NULL";
            }
            if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $imperfection))
                $valid = false;
        }
        return $valid;
    }

    private function incrementalNumberAlreadyExists() {
        if(($this->newIncrementalNumber) == ($this->oldIncrementalNumber))
            return true;
        if(!$this->checkIncrementalNumber($this->newIncrementalNumber))
            return false;
        return true;
    }

    private function issueNumberAlreadyExists() {
        if(($this->newIssueNumber) == ($this->oldIssueNumber))
            return true;
        if(!$this->checkIssueNumber($this->newIssueNumber))
            return false;
        return true;
    }

    private function ISBNAlreadyExists() {
        if(($this->newISBN) == ($this->oldISBN))
            return true;
        if(!$this->checkISBN($this->newISBN))
            return false;
        return true;
    }

    private function ISBNDoesNotExist() {
        if($this->checkISBN($this->oldISBN))
            return false;
        return true;
    }
}
?>