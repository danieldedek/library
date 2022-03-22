<?php

if(isset($_POST["rowButton"])) {

   $id = $books[$_POST["rowButton"]];
   echo $id;

   $user = unserialize($_SESSION['user'])->getIdUser();
   echo $user;

   $stmt = $this->connect()->prepare(
    'INSERT INTO author(user_id_user, copy_id_copy, from_date, to_date, suffix_to_key) VALUES(?, ?, ?, ?, ?);');

    if(!$stmt->execute(array())) {
        $stmt = null;
        echo '<div class="wrapper"><p>stmt failed</p></div>';
        return;
    }
}
?>