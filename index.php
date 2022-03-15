<?php
session_start();
include "./classes/user.php";
$user = unserialize($_SESSION['user']);
echo '<p>' . $user->getIdUser() . '</p>';
?>