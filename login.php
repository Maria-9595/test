<?php
require 'connect.php';

if(isset($_COOKIE['user']) && $_COOKIE['user'] !== "") {
    header('Location: index.php');
}

if (isset($_POST['login']) && isset($_POST['pass']) && $_POST['login'] !== "" && $_POST['pass'] !== "") {
    $user = R::findOne( 'user', 'login = ?', [$_POST['login']]);
    if ($user != null) {
        if (password_verify($_POST['pass'], $user->password)) {
            setcookie('user', $user->token);
            header('Location: index.php');
        }
        else {
            echo "Неверный пароль";
        }
    } else {
        echo "Пользователь не найден";
    }
}
?>

<div>
    <p>Вход</p>
    <form method="post">
        <p> <input type="text" name="login"> </p>
        <p> <input type="password" name="pass"> </p>
        <button type="submit">Войти</button>
        <p>
            У вас нет аккаунта? - <a href="registration.php">Зарегистрируйтесь</a>
        </p>
    </form>
</div>


