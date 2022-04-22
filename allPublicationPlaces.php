<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Všechna místa vydání
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
         include "./includes/allPublicationPlaces.inc.php";
      }
      else
         echo "<p>Pro zobrazení obsahu této stránky nemáte dostatečná oprávnění</p>";
   }
   else
      echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit a mít dostatečná oprávnění</p>";

include "./footer.php";
?>