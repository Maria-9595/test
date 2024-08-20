<?php
require 'connect.php';

if(isset($_COOKIE['user']) && $_COOKIE['user'] !== "") {
    header('Location: index.php');
}

if (isset($_POST['login']) && $_POST['login'] !== ""
    && isset($_POST['pass']) && $_POST['pass'] !== ""
    && isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $user = R::findOne('user', 'login = ?', [$_POST['login']]);
    if ($user != null) {
        echo "Логин занят";
    } else {
        $user = R::dispense('user');
        $user->login = $_POST['login'];
        $user->password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $user->email = $_POST['email'];
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $user->token = substr(str_shuffle($permitted_chars), 0, 20);
        $token = R::findOne('user', 'token = ?', [$user->token]);
        if ($token == null) {
            $user->token = substr(str_shuffle($permitted_chars), 2, 22);
        }
        $id = R::store($user);
        header('Location: login.php');
    }
}
?>

<div>
    <p>Регистрация</p>
    <form method="post">
        <p> <input type="text" name="login"> </p>
        <p> <input type="password" name="pass"> </p>
        <p> <input type="email" name="email"> </p>
        <button type="submit">Войти</button>
        <p>
            У вас есть аккаунт? - <a href="login.php">Войти</a>
        </p>
    </form>
</div>


