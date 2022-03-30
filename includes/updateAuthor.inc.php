<?php

if(isset($_POST["submit"])) {

   $newName = htmlspecialchars($_POST["author"]);
   $oldName = htmlspecialchars($_GET['authorName']);

   include "./classes/dbh.classes.php";
   include "./classes/updateAuthor.classes.php";
   include "./classes/updateAuthor-contr.classes.php";

   $updateAuthor = new UpdateAuthorContr($newName, $oldName);

   $updateAuthor->updateAuthor();
}
?>