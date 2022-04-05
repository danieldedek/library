<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Registrace
   </div>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="firstName">Křestní jméno:</label>
            <input type="text" name="firstName" id="firstName" class="input">
         </div>
         <div class="inputField">
            <label for="lastName">Příjmení:</label>
            <input type="text" name="lastName" id="lastName" class="input">
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
            <label for="passwordVerification">Potvrzení hesla:</label>
            <input type="password" name="passwordVerification" id="passwordVerification" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Registrovat se</button>
         </div>
      </form>
   </div>
</div>

<?php
include "./includes/signUp.inc.php";
include "./footer.php";
?>