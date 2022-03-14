<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání vydavatele
   </div>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="publisherName">Jnéno vydavatelství:</label>
            <input type="text" name="publisherName" id="publisherName" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat vydavatele</button>
         </div>
      </form>
   </div>
</div>

<?php
include "./includes/addPublisher.inc.php";
include "./footer.php";
?>