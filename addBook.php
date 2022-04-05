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
            <label for="book">Název knihy:</label>
            <input type="text" name="book" id="book" class="input"
            <?php
            if(isset($_GET['book'])) {
               echo(' value="' . $_GET['book'] . '"');
            }
            if(isset($_POST['book'])) {
               echo(' value="' . $_POST['book'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="incrementalNumber">Přírůstkové číslo:</label>
            <input type="text" name="incrementalNumber" id="incrementalNumber" class="input"
            <?php
            if(isset($_GET['incrementalNumber'])) {
               echo(' value="' . $_GET['incrementalNumber'] . '"');
            }
            if(isset($_POST['incrementalNumber'])) {
               echo(' value="' . $_POST['incrementalNumber'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="acquisitionDate">Datum zařazení do knihovny:</label>
            <input type="text" name="acquisitionDate" id="acquisitionDate" class="input"
            <?php
            if(isset($_GET['acquisitionDate'])) {
               echo(' value="' . $_GET['acquisitionDate'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="price">Cena:</label>
            <input type="text" name="price" id="price" class="input"
            <?php
            if(isset($_GET['price'])) {
               echo(' value="' . $_GET['price'] . '"');
            }
            if(isset($_POST['price'])) {
               echo(' value="' . $_POST['price'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="purchaseDocument">Doklad o koupi:</label>
            <input type="text" name="purchaseDocument" id="purchaseDocument" class="input"
            <?php
            if(isset($_GET['purchaseDocument'])) {
               echo(' value="' . $_GET['purchaseDocument'] . '"');
            }
            if(isset($_POST['purchaseDocument'])) {
               echo(' value="' . $_POST['purchaseDocument'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="seller">Získáno od:</label>
            <input type="text" name="seller" id="seller" class="input"
            <?php
            if(isset($_GET['seller'])) {
               echo(' value="' . $_GET['seller'] . '"');
            }
            if(isset($_POST['seller'])) {
               echo(' value="' . $_POST['seller'] . '"');
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
            if(isset($_POST['publicationYear'])) {
               echo(' value="' . $_POST['publicationYear'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="publicationPlace">Místo vydání:</label>
            <input type="text" name="publicationPlace" id="publicationPlace" class="input"
            <?php
            if(isset($_GET['publicationPlace'])) {
               echo(' value="' . $_GET['publicationPlace'] . '"');
            }
            if(isset($_POST['publicationPlace'])) {
               echo(' value="' . $_POST['publicationPlace'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="publisher">Vydavatel:</label>
            <input type="text" name="publisher" id="publisher" class="input"
            <?php
            if(isset($_GET['publisher'])) {
               echo(' value="' . $_GET['publisher'] . '"');
            }
            if(isset($_POST['publisher'])) {
               echo(' value="' . $_POST['publisher'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="issueNumber">Číslo vydání:</label>
            <input type="text" name="issueNumber" id="issueNumber" class="input"
            <?php
            if(isset($_GET['issueNumber'])) {
               echo(' value="' . $_GET['issueNumber'] . '"');
            }
            if(isset($_POST['issueNumber'])) {
               echo(' value="' . $_POST['issueNumber'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="pageCount">Počet stran:</label>
            <input type="text" name="pageCount" id="pageCount" class="input"
            <?php
            if(isset($_GET['pageCount'])) {
               echo(' value="' . $_GET['pageCount'] . '"');
            }
            if(isset($_POST['pageCount'])) {
               echo(' value="' . $_POST['pageCount'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="UDC">Mezinárodní desetinné třídění:</label>
            <input type="text" name="UDC" id="UDC" class="input"
            <?php
            if(isset($_GET['UDC'])) {
               echo(' value="' . $_GET['UDC'] . '"');
            }
            if(isset($_POST['UDC'])) {
               echo(' value="' . $_POST['UDC'] . '"');
            }
            ?>
            >
         </div>
         <div class="inputField">
            <label for="signature">Signatura:</label>
            <input type="text" name="signature" id="signature" class="input"
            <?php
            if(isset($_GET['signature'])) {
               echo(' value="' . $_GET['signature'] . '"');
            }
            if(isset($_POST['signature'])) {
               echo(' value="' . $_POST['signature'] . '"');
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
            if(isset($_POST['ISBN'])) {
               echo(' value="' . $_POST['ISBN'] . '"');
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
         <?php
         if(isset($_GET['ISBN'])) {
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