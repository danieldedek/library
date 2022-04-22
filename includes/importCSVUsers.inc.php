<?php
if(isset($_POST['submit'])) {
    $fileName = $_FILES['fileToUpload']['tmp_name'];

    if($_FILES['fileToUpload']['size'] > 0) {
        $file = fopen($fileName, "r");

        include "./classes/dbh.classes.php";
        include "./classes/addUser.classes.php";
        include "./classes/addUser-contr.classes.php";

        $count = 0;
        while(($line = fgetcsv($file, 10000, ";")) !== FALSE) {
            $count++;
            if ($count == 1)
                continue;
            $firstName = htmlspecialchars($line[0]);
            $lastName = htmlspecialchars($line[1]);
            $mail = htmlspecialchars($line[2]);
            $password = htmlspecialchars($line[3]);
            $role = htmlspecialchars($line[4]);

            $addUser = new AddUserContr($firstName, $lastName, $mail, $password, $role);

            $addUser->addUser();
        }

        fclose($file);
    }
}
?>