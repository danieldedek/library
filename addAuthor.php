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
/*
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
            <label for="imperfection">Poškození:</label>
            <input type="text" name="imperfection" id="imperfection" class="input">
         </div>
         <div class="inputField">
            <label for="publisher">Vydavatel:</label>
            <input type="text" name="publisher" id="publisher" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit2" class="button">Knihu</button>
         </div>
      </form>
   </div>
</div>

<div class="wrapper">
   <div class="title">
      Přidání uživatele
   </div>
   <div class="form">
      <form method="POST">
         <div class="inputField">
            <label for="firstName">Křestní jméno:</label>
            <input type="text" name="firstName" id="firstName" class="input">
         </div>
         <div class="inputField">
            <label for="keyName">Příjmení:</label>
            <input type="text" name="keyName" id="keyName" class="input">
         </div>
         <div class="inputField">
            <label for="mail">Školní mail:</label>
            <input type="text" name="mail" id="mail" class="input">
         </div>
         <div class="inputField">
            <label for="password">Heslo:</label>
            <input type="password" name="password" id="password" class="input">
         </div>
         <div class="inputField">
            <label for="passwordVerification">Potvrzení hesla:</label>
            <input type="password" name="passwordVerification" id="passwordVerification" class="input">
         </div>
         <div class="inputField">
            <label for="role">Oprávnění:</label>
            <input type="text" name="role" id="role" class="input">
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Přidat uživatele</button>
         </div>
      </form>
   </div>
</div>
*/
include "./includes/addAuthor.inc.php";
include "./footer.php";
?>