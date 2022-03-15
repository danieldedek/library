<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání poškození
   </div>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="imperfection">Závada:</label>
            <input type="text" name="imperfection" id="imperfection" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat vydavatele</button>
         </div>
      </form>
   </div>
</div>

<?php
include "./includes/addImperfection.inc.php";
include "./footer.php";
?>