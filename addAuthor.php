<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání autora
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="name">Jméno autora:</label>
            <input type="text" name="name" id="name" class="input"
            <?php
            if(isset($idAuthor)) {
               echo(' value=" ' . $nameAuthor . '"');
            }
            ?>
            >
         </div>
         <?php
         if(isset($idAuthor)) {
         ?>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Upravit autora</button>
         </div>
         <?php
         }
         else {
         ?>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat autora</button>
         </div>
         <?php
         }
         ?>
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
include "./includes/addAuthor.inc.php";
include "./footer.php";
?>