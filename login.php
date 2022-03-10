<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přihlášení
   </div>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="mail">Školní mail:</label>
            <input type="text" name="mail" id="mail" class="input" required>
         </div>
         <div class="inputField">
            <label for="password">Heslo:</label>
            <input type="password" name="password" id="password" class="input" required>
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přihlásit se</button>
         </div>
      </form>
   </div>
</div>

<?php
include "./includes/logIn.inc.php";
include "./footer.php";
?>