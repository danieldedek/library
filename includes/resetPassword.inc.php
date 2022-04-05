<?php

if(isset($_POST['submit'])) {
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['password'];
    $passwordVerification = $_POST['passwordVerification'];

    if(empty($password) || empty($passwordVerification)) {
        header("Location: ../logIn.php");
        exit();
    }

    elseif($password != $passwordVerification) {
        header("Location: ../createNewPassword.php?newPassword=passwordsDontMatch");
        exit();
    }

    $currentDate = date("U");

    include "../classes/dbh.classes.php";
    include "../classes/resetPassword.classes.php";
    include "../classes/resetPassword-contr.classes.php";

    $resetPassword = new ResetPasswordContr($selector, $currentDate, $validator, $password);

    $resetPassword->verifyReset();
}

else
    header("Location: ../index.php");
?>