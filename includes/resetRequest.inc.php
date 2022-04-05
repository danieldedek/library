<?php
if(isset($_POST["submit"])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost/createNewPassword.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    include "../classes/dbh.classes.php";
    include "../classes/resetRequest.classes.php";
    include "../classes/resetRequest-contr.classes.php";
    include "../mail.php";

    $userMail = $_POST["mail"];
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);

    $resetRequest = new ResetRequestContr($userMail, $selector, $hashedToken, $expires);

    $resetRequest->deleteResetRequest();
    $resetRequest->addResetRequest();

    $subject = 'Resetování hesla u školní knihovny';
    $msg = '<p>Odkaz na resetování hesla:</br>';

    $msg .= '<a href="' . $url . '">' . $url . '</a></p>';

    smtp_mailer($userMail, $subject, $msg);

    header("Location: ../resetPassword.php?reset=success");
}

else
    header("Location: ../index.php");
?>