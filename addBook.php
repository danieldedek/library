<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Přidání knihy
   </div>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="authorName">Jméno autora:</label>
            <input type="text" name="authorName" id="authorName" class="input">
         </div>
         <div class="inputField">
            <label for="bookName">Název knihy:</label>
            <input type="text" name="bookName" id="bookName" class="input">
         </div>
         <div class="inputField">
            <label for="publicationYear">Rok vydání:</label>
            <input type="text" name="publicationYear" id="publicationYear" class="input">
         </div>
         <div class="inputField">
            <label for="ISBN">ISBN:</label>
            <input type="text" name="ISBN" id="ISBN" class="input">
         </div>
         <div class="inputField">
            <label for="registrationNumber">Registrační číslo:</label>
            <input type="text" name="registrationNumber" id="registrationNumber" class="input">
         </div>
         <div class="inputField">
            <label for="imperfection">Závada:</label>
            <input type="text" name="imperfection" id="imperfection" class="input">
         </div>
         <div class="inputField">
            <label for="publisherName">Vydavatel:</label>
            <input type="text" name="publisherName" id="publisherName" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat knihu</button>
         </div>
      </form>
   </div>
</div>

<?php
include "./includes/addBook.inc.php";
include "./footer.php";
?>