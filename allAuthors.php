<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Všichni autoři
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
         include "./includes/allAuthors.inc.php";
      }
   }
   else
      echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit a mít dostatečná oprávnění</p>";

include "./footer.php";
?>