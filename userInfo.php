<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Informace
   </div>
   <?php
   echo "<p>" . unserialize($_SESSION['user'])->getFirstName() . "</p>";
   echo "<p>" . unserialize($_SESSION['user'])->getKeyName() . "</p>";
   echo "<p>" . unserialize($_SESSION['user'])->getMail() . "</p>";
   echo "<p>" . unserialize($_SESSION['user'])->getSendMail() . "</p>";

include "./includes/userInfo.inc.php";
include "./footer.php";
?>