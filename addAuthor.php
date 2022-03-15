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
            <button type="submit" name="submit" class="button">Přidat autora</button>
         </div>
      </form>
   </div>
</div>

<?php
include "./includes/addAuthor.inc.php";
include "./footer.php";
?>