<?php

class UpdateUserContr extends UpdateUser {
    
    private $newFirstName;
    private $newKeyName;
    private $newMail;
    private $newPassword;
    private $newRole;
    private $oldMail;
    private $wrongInputs;

    public function __construct($newFirstName, $newKeyName, $newMail, $newPassword, $newRole, $oldMail) {
        $this->newFirstName = $newFirstName;
        $this->newKeyName = $newKeyName;
        $this->newMail = $newMail;
        $this->newPassword = $newPassword;
        $this->newRole = $newRole;
        $this->oldMail = $oldMail;
        $this->wrongInputs = array();
    }

    public function updateUser() {
        if($this->invalidFirstName() == false)
            array_push($this->wrongInputs, "Křesní jméno musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidKeyName() == false)
            array_push($this->wrongInputs, "Příjmení musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
        if($this->invalidMail() == false)
            array_push($this->wrongInputs, "Email musí být uveden v následujícím formátu: prijmeni.jmeno@purkynka.cz");
        if($this->invalidPassword() == false)
            array_push($this->wrongInputs, "Heslo musí obsahovat minimálně 8 znaků a aspoň: 1 velké písmeno, 1 malé písmeno a 1 číslici");
        if($this->invalidRole() == false)
            array_push($this->wrongInputs, "Špatně zvolená role");
        if($this->mailDoesNotExist() == true)
            array_push($this->wrongInputs, "Tohoto uživatele nelze upravit");
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
        $this->setUser($this->oldMail, $this->newFirstName, $this->newKeyName, $this->newMail, $this->newPassword, $this->newRole);
        echo '<div class="wrapper"><p>Úprava uživatele proběhla úspěšně</p></div>';
    }

    private function invalidFirstName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newFirstName))
            return false;
        return true;
    }

    private function invalidKeyName() {
        if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $this->newKeyName))
            return false;
        return true;
    }

    private function invalidMail() {
        if(!preg_match("/^[a-z]+\.[a-z]+@purkynka\.cz$/mu", $this->newMail))
            return false;
        return true;
    }

    private function invalidPassword() {
        if(preg_match("/^$/mu", $this->newPassword)) {
            $this->newPassword = "NULL";
            return true;
        }
        if(!((preg_match("/.*[A-Z].*/mu", $this->newPassword))&(preg_match("/.*[a-z].*/mu", $this->newPassword))&(preg_match("/.*\d.*/mu", $this->newPassword))&(preg_match("/........+/mu", $this->newPassword))))
            return false;
        return true;
    }

    private function invalidRole() {
        if(!preg_match("/^administrator$|^employee$|^customer$/mu", $this->newRole))
            return false;
        return true;
    }

    private function mailDoesNotExist() {
        if($this->checkUser($this->oldMail))
            return false;
        return true;
    }

    private function mailTaken() {
        if(!$this->checkUser($this->newMail))
            return false;
        return true;
    }
}
?>