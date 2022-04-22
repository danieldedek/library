<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
        Import uživatelů ze souboru CSV
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST" enctype="multipart/form-data">
         <div class="inputField">
            <label for="fileToUpload">Zvolte CSV soubor:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" class="input" accept=".csv">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Načíst CSV soubor</button>
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
include "./includes/importCSVUsers.inc.php";
include "./footer.php";
?>