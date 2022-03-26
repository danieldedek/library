<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Informace
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      echo "<p>" . unserialize($_SESSION['user'])->getFirstName() . "</p>";
      echo "<p>" . unserialize($_SESSION['user'])->getKeyName() . "</p>";
      echo "<p>" . unserialize($_SESSION['user'])->getMail() . "</p>";
      echo "<p>" . unserialize($_SESSION['user'])->getSendMail() . "</p>";

      include "./includes/userInfo.inc.php";
   }

   else
      echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit</p>";

include "./footer.php";
?>