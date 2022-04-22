<?php
include "./header.php";
?>

<div class="wrapper">
   <div class="title">
      Obnova hesla
   </div>
   <div class="form">
      <form action="includes/resetRequest.inc.php" method="POST">
         <div class="inputField">
            <label for="mail">Školní mail:</label>
            <input type="text" name="mail" id="mail" class="input" required>
         </div>
         <div class="inputField">
            <button type="submit" name="submit" class="button">Obnovit heslo</button>
         </div>
      </form>
      <?php
      if(isset($_GET['reset'])) {
         if($_GET['reset'] == "success") {
            echo "<p>Podívejte se na mail!</p>";
         }
      }
      ?>
   </div>
</div>

<?php
include "./footer.php";
?>