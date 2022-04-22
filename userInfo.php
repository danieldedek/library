<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Informace
   </div>
   <?php
   if(isset($_SESSION['user'])) {
      echo "<table><tr><th>Křestní jméno</th><td>" . unserialize($_SESSION['user'])->getFirstName() . "</td></tr>";
      echo "<tr><th>Příjmení</th><td>" . unserialize($_SESSION['user'])->getKeyName() . "</td></tr>";
      echo "<tr><th>Mail</th><td>" . unserialize($_SESSION['user'])->getMail() . "</td></tr>";
      ?>

      <form method="POST">
      <tr><th>Doručování mailů</th><td><input type="radio" name="sendMail" value="yes"
         <?php
         if((unserialize($_SESSION['user'])->getSendMail()) == 1)
            echo "checked";
         ?>>ano
         <input type="radio" name="sendMail" value="no"
         <?php
         if((unserialize($_SESSION['user'])->getSendMail()) == 0)
            echo "checked";
         ?>>ne
         <button type="submit" name="submit">Potvrdit</button></td></tr></table><br />
      </form>

      <?php
      include "./includes/userInfo.inc.php";
   }

   else
      echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit</p>";
   ?>
</div>

<?php
include "./footer.php";
?>