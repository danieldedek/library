<!DOCTYPE html>
<html lang="cs">
<head>
   <title>Registration</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="wrapper">
   <div class="title">
      Registrace
   </div>
   <div class="form">
      <form method="POST">
         <div class="input_field">
            <label for="first_name">Křestní jméno:</label>
            <input type="text" name="first_name" id="first_name" class="input">
         </div>
         <div class="input_field">
            <label for="key_name">Příjmení:</label>
            <input type="text" name="key_name" id="key_name" class="input">
         </div>
         <div class="input_field">
            <label for="mail">Školní mail:</label>
            <input type="text" name="mail" id="mail" class="input">
         </div>
         <div class="input_field">
            <label for="password">Heslo:</label>
            <input type="password" name="password" id="password" class="input">
         </div>
         <div class="input_field">
            <label for="confirm_password">Potvrzení hesla:</label>
            <input type="password" name="confirm_password" id="confirm_password" class="input">
         </div>
         <div class="input_field">
            <button type="submit" name="submit" class="button">Registrovat se </button>
         </div>
      </form>
   </div>
</div>
</body>
</html>

<?php
if(isset($_POST["submit"])) {
   include "./data.php";

   $first_name = htmlspecialchars($_POST["first_name"]);
   $key_name = htmlspecialchars($_POST["key_name"]);
   $mail = htmlspecialchars($_POST["mail"]);
   $password = htmlspecialchars($_POST["password"]);
   $confirm_password = htmlspecialchars($_POST["confirm_password"]);

   $wrong_inputs = array();

   if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $first_name))
      array_push($wrong_inputs, "Křesní jméno musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
   if(!preg_match("/^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+(\s[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ][a-záčďéěíňóřšťúůýž]+)?$/mu", $key_name))
      array_push($wrong_inputs, "Příjmení musí vždy začínat velkým písmenem a může obsahovat maximálně dvě slova, která jsou oddělená jednou mezerou");
   if(!preg_match("/^[a-z]+\.[a-z]+@purkynka\.cz$/mu", $mail))
      array_push($wrong_inputs, "Email musí být uveden v následujícím formátu: prijmeni.jmeno@purkynka.cz");

   $pdo = new PDO($dsn, $user, $psw) or die("failed to connect to database");
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) or die("failed to set encoding");

   try {
      $query = $pdo->prepare("SELECT mail FROM user WHERE mail = '$mail'");
      $query->execute();
      $count = $query->fetch();
      if($count != 0)
         array_push($wrong_inputs, "Již existuje účet s tímto emailem");
   }
   catch(Exception $e) {
      echo('incorrect query');
   }
   $pdo = null;

   if(!((preg_match("/.*[A-Z].*/mu", $password))&(preg_match("/.*[a-z].*/mu", $password))&(preg_match("/.*\d.*/mu", $password))&(preg_match("/........+/mu", $password))))
      array_push($wrong_inputs, "Heslo musí obsahovat minimálně 8 znaků a aspoň: 1 velké písmeno, 1 malé písmeno a 1 číslici");
   if($password !== $confirm_password)
      array_push($wrong_inputs, "Hesla se musí shodovat");

   $password = password_hash($password, PASSWORD_BCRYPT);

   if(!empty($wrong_inputs)) {
      echo '<div class="wrapper">';
      foreach($wrong_inputs as $wrong_input) {
         echo "<p>" . $wrong_input . "</p>";
      }
      echo "</div>";
   }
   else {
      $pdo = new PDO($dsn, $user, $psw) or die("failed to connect to database");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) or die("failed to set encoding");

      try {
         $query = $pdo->prepare("INSERT INTO user(first_name, key_name, mail, password, role_id_role, send_mail) VALUES('$first_name', '$key_name', '$mail', '$password', '1', '1')");
         $query->execute();
      }
      catch(Exception $e) {
         echo('incorrect query');
      }
      $pdo = null;
   }
}
?>