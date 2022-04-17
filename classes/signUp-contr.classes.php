<?php

class SignUpContr extends SignUp {
    
    private $firstName;
    private $lastName;
    private $mail;
    private $password;
    private $passwordVerification;
    private $verificationCode;
    private $wrongInputs;

    public function __construct($firstName, $lastName, $mail, $password, $passwordVerification, $verificationCode) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->mail = $mail;
        $this->password = $password;
        $this->passwordVerification = $passwordVerification;
        $this->verificationCode = $verificationCode;
        $this->wrongInputs = array();
    }

    public function signUpUser() {
        if($this->invalidFirstName() == false)
            array_push($this->wrongInputs, "Křesní jméno musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidLastName() == false)
            array_push($this->wrongInputs, "Příjmení musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidMail() == false)
            array_push($this->wrongInputs, "Email musí být uveden v následujícím formátu: prijmeni.jmeno@purkynka.cz");
        if($this->invalidPassword() == false)
            array_push($this->wrongInputs, "Heslo musí obsahovat minimálně 8 znaků a aspoň: 1 velké písmeno, 1 malé písmeno a 1 číslici");
        if($this->passwordMatch() == false)
            array_push($this->wrongInputs, "Hesla se musí shodovat");
        if($this->mailTaken() == false)
            array_push($this->wrongInputs, "Již existuje účet s tímto emailem");
        if(!empty($this->wrongInputs)) {
            echo '<div class="wrapper">';
            foreach($this->wrongInputs as $wrongInput) {
                echo "<p>" . $wrongInput . "</p>";
            }
            echo "</div>";
            return;
        }
        $this->setUser($this->firstName, $this->lastName, $this->mail, $this->password, $this->verificationCode);
        echo '<div class="wrapper"><p>Registrace proběhla úspěšně</p></div>';
    }

    private function invalidFirstName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->firstName))
            return false;
        return true;
    }

    private function invalidLastName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->lastName))
            return false;
        return true;
    }

    private function invalidMail() {
        if(!preg_match("/^[a-z]+\.[a-z]+@purkynka\.cz$/mu", $this->mail))
            return false;
        return true;
    }

    private function invalidPassword() {
        if(!((preg_match("/.*[A-Z].*/mu", $this->password))&(preg_match("/.*[a-z].*/mu", $this->password))&(preg_match("/.*\d.*/mu", $this->password))&(preg_match("/........+/mu", $this->password))))
            return false;
        return true;
    }

    private function passwordMatch() {
        if($this->password !== $this->passwordVerification)
            return false;
        return true;
    }

    private function mailTaken() {
        if(!$this->checkUser($this->mail))
            return false;
        return true;
    }
}
?>