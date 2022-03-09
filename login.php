<!DOCTYPE html>
<html lang="cs">
<head>
   <title>Login</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="wrapper">
   <div class="title">
      Přihlášení
   </div>
   <div class="form">
      <form method="POST">
         <div class="input_field">
            <label for="mail">Školní mail:</label>
            <input type="text" name="mail" id="mail" class="input" required>
         </div>
         <div class="input_field">
            <label for="password">Heslo:</label>
            <input type="password" name="password" id="password" class="input" required>
         </div>
         <div class="input_field">
            <button type="submit" name="submit" class="button">Přihlásit se</button>
         </div>
      </form>
   </div>
</div>
</body>
</html>

<?php
if(isset($_POST["submit"])) {
   include "./data.php";

   $mail = htmlspecialchars($_POST["mail"]);
   $password = htmlspecialchars($_POST["password"]);

   $pdo = new PDO($dsn, $user, $psw) or die("failed to connect to database");
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) or die("failed to set encoding");

   try {
      $query = $pdo->prepare("SELECT mail, password FROM user WHERE mail = '$mail'");
      $query->execute();
      $user = $query->fetch();
      if(!password_verify($password, $user["password"])) {
         echo '<div class="wrapper"><p>Špatné přihlašovací údaje</p></div>';
      }
      else
         echo "KAREL";
   }
   catch(Exception $e) {
      echo('incorrect query');
   }
   $pdo = null;
}
?>