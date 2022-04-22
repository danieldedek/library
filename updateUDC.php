<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Úprava mezinárodního desetinného třídění
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="UDC">Mezinárodní desetinné třídění:</label>
            <input type="text" name="UDC" id="UDC" class="input"
            <?php
            if(isset($_GET['UDC'])) {
               echo(' value="' . $_GET['UDC'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Upravit vydavatele</button>
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
include "./includes/updateUDC.inc.php";
include "./footer.php";
?>