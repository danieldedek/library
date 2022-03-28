<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání vydavatele
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="publisherName">Jméno vydavatelství:</label>
            <input type="text" name="publisherName" id="publisherName" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat vydavatele</button>
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
include "./includes/addPublisher.inc.php";
include "./footer.php";
?>