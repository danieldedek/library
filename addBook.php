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
            <label for="namesBeforeKey">Names before key:</label>
            <input type="text" name="namesBeforeKey" id="namesBeforeKey" class="input">
         </div>
         <div class="inputField">
            <label for="prefixToKey">Prefix to key:</label>
            <input type="text" name="prefixToKey" id="prefixToKey" class="input">
         </div>
         <div class="inputField">
            <label for="keyName">Key name:</label>
            <input type="text" name="keyName" id="keyName" class="input">
         </div>
         <div class="inputField">
            <label for="namesAfterKey">Names after key:</label>
            <input type="text" name="namesAfterKey" id="namesAfterKey" class="input">
         </div>
         <div class="inputField">
            <label for="suffixToKey">Suffix to key:</label>
            <input type="text" name="suffixToKey" id="suffixToKey" class="input">
         </div>
         <div class="inputField">
            <label for="bookName">Název knihy:</label>
            <input type="text" name="bookName" id="bookName" class="input">
         </div>
         <div class="inputField">
            <label for="publicationDate">Rok vydání:</label>
            <input type="text" name="publicationDate" id="publicationDate" class="input">
         </div>
         <div class="inputField">
            <label for="ISBN">ISBN:</label>
            <input type="text" name="ISBN" id="ISBN" class="input">
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