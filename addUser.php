<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání uživatele
   </div>
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
</div>

<?php
include "./includes/addUser.inc.php";
include "./footer.php";
?>