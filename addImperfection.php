<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání závady
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="imperfection">Závada:</label>
            <input type="text" name="imperfection" id="imperfection" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat závadu</button>
         </div>
      </form>
   </div>
   <?php
      }
      else
         echo "<p>Pro zobrazení obsahu této stránky nemáte dostatečná oprávnění</p>";
   }
   else
      echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit a mít dostatečná oprávnění</p>";
   ?>
</div>

<?php
include "./includes/addImperfection.inc.php";
include "./footer.php";
?>