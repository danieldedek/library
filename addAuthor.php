<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání autora
   </div>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="name">Jméno autora:</label>
            <input type="text" name="name" id="name" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat autora</button>
         </div>
      </form>
   </div>
</div>

<?php
include "./includes/addAuthor.inc.php";
include "./footer.php";
?>