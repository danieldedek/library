<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Upravit prodejce
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="seller">Jméno prodejce:</label>
            <input type="text" name="seller" id="seller" class="input"
            <?php
            if(isset($_GET['seller'])) {
               echo(' value="' . $_GET['seller'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Upravit prodejce</button>
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
include "./includes/updateSeller.inc.php";
include "./footer.php";
?>