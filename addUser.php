<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání uživatele
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="firstName">Křestní jméno:</label>
            <input type="text" name="firstName" id="firstName" class="input">
         </div>
         <div class="inputField">
            <label for="keyName">Příjmení:</label>
            <input type="text" name="keyName" id="keyName" class="input">
         </div>
         <div class="inputField">
            <label for="mail">Školní mail:</label>
            <input type="text" name="mail" id="mail" class="input">
         </div>
         <div class="inputField">
            <label for="password">Heslo:</label>
            <input type="password" name="password" id="password" class="input">
         </div>
         <div class="inputField">
            <label for="role">Oprávnění:</label>
            <input type="text" name="role" id="role" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat uživatele</button>
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
include "./includes/addUser.inc.php";
include "./footer.php";
?>