<?php

class AddBookContr extends AddBook {
    
    private $authorNames;
    private $book;
    private $incrementalNumber;
    private $acquisitionDate;
    private $price;
    private $purchaseDocument;
    private $seller;
    private $publicationYear;
    private $publicationPlace;
    private $publisher;
    private $issueNumber;
    private $pageCount;
    private $UDC;
    private $signature;
    private $ISBN;
    private $imperfections;
    private $wrongInputs;

    public function __construct($authorNames, $book, $incrementalNumber, $acquisitionDate, $price, $purchaseDocument, $seller, $publicationYear, $publicationPlace, $publisher, $issueNumber, $pageCount, $UDC, $signature, $ISBN, $imperfections) {
        $this->authorNames = $authorNames;
        $this->book = $book;
        $this->incrementalNumber = $incrementalNumber;
        $this->acquisitionDate = $acquisitionDate;
        $this->price = $price;
        $this->purchaseDocument = $purchaseDocument;
        $this->seller = $seller;
        $this->publicationYear = $publicationYear;
        $this->publicationPlace = $publicationPlace;
        $this->publisher = $publisher;
        $this->issueNumber = $issueNumber;
        $this->pageCount = $pageCount;
        $this->UDC = $UDC;
        $this->signature = $signature;
        $this->ISBN = $ISBN;
        $this->imperfections = $imperfections;
        $this->wrongInputs = array();
    }

    public function addBook() {
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
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setBook($this->authorNames, $this->book, $this->incrementalNumber, $this->acquisitionDate, $this->price, $this->purchaseDocument, $this->seller, $this->publicationYear, $this->publicationPlace, $this->publisher, $this->issueNumber, $this->pageCount, $this->UDC, $this->signature, $this->ISBN, $this->imperfections);
        echo '<div class="wrapper"><p>Přidání knihy proběhlo úspěšně</p></div>';
    }

    private function invalidAuthorName() {
        $valid = true;
        foreach ($this->authorNames as $authorName) {
            if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $authorName))
                $valid = false;
        }
        return $valid;
    }

    private function invalidBook() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->book))
            return false;
        return true;
    }

    private function invalidIncrementalNumber() {
        if(!preg_match("/^[0-9]{1,6}$/mu", $this->incrementalNumber))
            return false;
        return true;
    }

    private function invalidAcquisitionDate() {
        if(preg_match("/^$/mu", $this->acquisitionDate)) {
            $acquisitionDate = "NULL";
            return true;
        }
        if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/mu", $this->acquisitionDate))
            return false;
        return true;
    }

    private function invalidPrice() {
        if(!preg_match("/^[0-9]{1,6}$/mu", $this->price))
            return false;
        return true;
    }

    private function invalidPurchaseDocument() {
        if(!preg_match("/^[0-9]{3,20}$/mu", $this->purchaseDocument))
            return false;
        return true;
    }

    private function invalidSeller() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->seller))
            return false;
        return true;
    }

    private function invalidPublicationYear() {
        if(!preg_match("/^[0-9]{4}$/mu", $this->publicationYear))
            return false;
        return true;
    }

    private function invalidPublicationPlace() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->publicationPlace))
            return false;
        return true;
    }

    private function invalidPublisher() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->publisher))
            return false;
        return true;
    }

    private function invalidIssueNumberr() {
        if(!preg_match("/^[0-9]{1,6}$/mu", $this->issueNumber))
            return false;
        return true;
    }
    
    private function invalidPageCount() {
        if(!preg_match("/^[0-9]{1,6}$/mu", $this->pageCount))
            return false;
        return true;
    }

    private function invalidUDC() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->UDC))
            return false;
        return true;
    }

    private function invalidSignature() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $this->signature))
            return false;
        return true;
    }

    private function invalidISBN() {
        if(!preg_match("/^[0-9]{13}$/mu", $this->ISBN))
            return false;
        return true;
    }

    private function invalidImperfection() {
        $valid = true;
        foreach ($this->imperfections as $imperfection) {
            if(preg_match("/^$/mu", $imperfection)) {
                $imperfection = "NULL";
            }
            if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýžA-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/mu", $imperfection))
                $valid = false;
        }
        return $valid;
    }

    private function incrementalNumberAlreadyExists() {
        if(!$this->checkIncrementalNumber($this->incrementalNumber))
            return false;
        return true;
    }

    private function issueNumberAlreadyExists() {
        if(!$this->checkIssueNumber($this->issueNumber))
            return false;
        return true;
    }

    private function ISBNAlreadyExists() {
        if(!$this->checkISBN($this->ISBN))
            return false;
        return true;
    }
}
?>