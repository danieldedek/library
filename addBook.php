<?php
include "./header.php";
include "./classes/dbh.classes.php";
?>

<script src="./script.js"></script>
<div class="wrapper">
<?php
if(isset($_GET['ISBN'])) {
   echo('<div class="title">Úprava knihy</div>');
}
else {
?>
   <div class="title">
      Přidání knihy
   </div>
   <?php
   }
   if(isset($_SESSION['user'])) {
      if(unserialize($_SESSION['user'])->getRole() == 2 || unserialize($_SESSION['user'])->getRole() == 3) {
   ?>
   <div class="form">
      <form method="POST">
         <div class="inputField" id="authorNameDiv">
            <label for="authorName">Jméno autora:</label>
            <input type="text" name="authorName[]" id="authorName" class="input"
            <?php
            if(isset($_GET['ISBN'])) {
               include "./classes/setAuthors.classes.php";
               include "./classes/setAuthors-contr.classes.php";

               $setAuthors = new SetAuthorsContr($_GET['ISBN']);

               $authors = $setAuthors->setAuthors();

               echo(' value="' . $authors[0] . '"');

               if (sizeof($authors) > 1) {
                  for ($i = 1; $i < sizeof($authors); $i++) {
                     echo('><label for="authorName">Jméno autora:</label><input type="text" name="authorName[]" id="authorName" class="input" value="' . $authors[$i] . '"');
                  }
               }
            }
            ?>
            >
         </div>
         <div class="controls">
            <a href="#" id="addFieldsAuthor">Přidat pole pro jméno autora</a>
            <a href="#" id="removeFieldsAuthor">Odebrat pole pro jméno autora</a>
         </div>
         <div class="inputField">
            <label for="bookName">Název knihy:</label>
            <input type="text" name="bookName" id="bookName" class="input"
            <?php
            if(isset($_GET['bookName'])) {
               echo(' value="' . $_GET['bookName'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="publicationYear">Rok vydání:</label>
            <input type="text" name="publicationYear" id="publicationYear" class="input"
            <?php
            if(isset($_GET['publicationYear'])) {
               echo(' value="' . $_GET['publicationYear'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="ISBN">ISBN:</label>
            <input type="text" name="ISBN" id="ISBN" class="input"
            <?php
            if(isset($_GET['ISBN'])) {
               echo(' value="' . $_GET['ISBN'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="registrationNumber">Registrační číslo:</label>
            <input type="text" name="registrationNumber" id="registrationNumber" class="input"
            <?php
            if(isset($_GET['registrationNumber'])) {
               echo(' value="' . $_GET['registrationNumber'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField" id="imperfectionDiv">
         <?php
            if(isset($_GET['ISBN'])) {
               include "./classes/setImperfections.classes.php";
               include "./classes/setImperfections-contr.classes.php";

               $setImperfections = new SetImperfectionsContr($_GET['ISBN']);

               $imperfections = $setImperfections->setImperfections();

               for ($i = 0; $i < sizeof($imperfections); $i++) {
                  echo('<label for="imperfection">Závada:</label><input type="text" name="imperfection[]" id="imperfection" class="input" value="' . $imperfections[$i] . '">');
               }
            }
            ?>
         </div>
         <div class="controls">
            <a href="#" id="addFieldsImperfection">Přidat pole pro závadu</a>
            <a href="#" id="removeFieldsImperfection">Odebrat pole pro závadu</a>
         </div>
         <div class="inputField">
            <label for="publisherName">Vydavatel:</label>
            <input type="text" name="publisherName" id="publisherName" class="input"
            <?php
            if(isset($_GET['publisherName'])) {
               echo(' value="' . $_GET['publisherName'] . '"');
            }
            ?>
            >
         </div>
         <?php
         if(isset($_GET['mail'])) {
            echo('<div class="inputField"><button type="submit" name="submit1" class="button">Upravit knihu</button></div>');
         }
         else {
         ?>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat knihu</button>
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
include "./includes/addBook.inc.php";
include "./includes/updateBook.inc.php";
include "./footer.php";
?>