<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Úprava autora
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="author">Jméno autora:</label>
            <input type="text" name="author" id="author" class="input"
            <?php
            if(isset($_GET['authorName'])) {
               echo(' value="' . $_GET['authorName'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Upravit autora</button>
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
include "./includes/updateAuthor.inc.php";
include "./footer.php";
?>