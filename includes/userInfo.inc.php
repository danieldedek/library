<?php

$idUser = unserialize($_SESSION['user'])->getIdUser();

if(isset($_POST['submit'])) {
    if(isset($_POST['sendMail'])) {
        if($_POST['sendMail'] == "yes")
            $sendMail = 1;
        else
            $sendMail = 0;
    }
    include "./classes/dbh.classes.php";
    include "./classes/userInfo.classes.php";
    include "./classes/userInfo-contr.classes.php";

    $showBorrowedBooks = new UserInfoContr($idUser, $sendMail);

    $showBorrowedBooks->showBorrowedBooks();
    $showBorrowedBooks->changeSendMail();
}

else {

    $sendMail = unserialize($_SESSION['user'])->getMail();  

    include "./classes/dbh.classes.php";
    include "./classes/userInfo.classes.php";
    include "./classes/userInfo-contr.classes.php";

    $showBorrowedBooks = new UserInfoContr($idUser, $sendMail);

    $showBorrowedBooks->showBorrowedBooks();
}
?>