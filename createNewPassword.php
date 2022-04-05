<?php
include "./header.php";
?>

<div class="wrapper">
    <?php
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];

    if(empty($selector) || empty($validator)) {
        echo "Žádost nelze ověřit";
    }

    elseif(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
    ?>
    <form action="./includes/resetPassword.inc.php" method="POST">
        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
        <div class="inputField">
            <label for="password">Nové heslo:</label>
            <input type="password" name="password" id="password" class="input">
        </div>
        <div class="inputField">
            <label for="passwordVerification">Potvrzení hesla:</label>
            <input type="password" name="passwordVerification" id="passwordVerification" class="input">
        </div>
        <div class="inputField">
            <button type="submit" name="submit" class="button">Resetovat heslo</button>
         </div>
    </form>
    <?php
    }
    ?>
</div>

<?php
include "./footer.php";
?>