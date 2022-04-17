<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Ověření mailu
   </div>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="verificationCode">Ověřovací kód:</label>
            <input type="text" name="verificationCode" id="verificationCode" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Registrovat se</button>
         </div>
      </form>
   </div>
</div>

<?php
include "./includes/mailVerification.inc.php";
include "./footer.php";
?>