<?php
require 'connect.php';

if(!isset($_COOKIE['user']) && $_COOKIE['user'] !== "") {
    header('Location: registration.php');
}
$user = R::findOne('user', 'token = ?', [$_COOKIE['user']]);

if (isset($_POST['exit'])) {
    setcookie("user", "", time() - 3600);
    header('Location: registration.php');
}
?>

<h1>Вы вошли???, <?=$user->login?></h1>
<form method="post">
    <input type="submit" value="Выход" name="exit">
</form>
