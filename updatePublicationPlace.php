<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Úprava místa vydání
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="publicationPlace">Místo vydání:</label>
            <input type="text" name="publicationPlace" id="publicationPlace" class="input"
            <?php
            if(isset($_GET['publicationPlace'])) {
               echo(' value="' . $_GET['publicationPlace'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Upravit místo vydání</button>
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
include "./includes/updatePublicationPlace.inc.php";
include "./footer.php";
?>