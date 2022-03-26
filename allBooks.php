<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Všechny knihy
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      include "./includes/allBooks.inc.php";
   }
   else
      echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit</p>";

include "./footer.php";
?>