<?php
session_start();
require_once 'models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    $login = $user->login($_POST['email'], $_POST['senha']);
    if ($login) {
        $_SESSION['user_id'] = $login['id'];
        $_SESSION['user_tipo'] = $login['tipo'];
        header("Location: index.php");
        exit();
    } else {
        echo "E-mail ou senha inválidos.";
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>
