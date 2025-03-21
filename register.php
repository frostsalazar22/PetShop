<?php
require_once 'models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    if ($user->register($_POST['nome'], $_POST['email'], $_POST['senha'])) {
        echo "Usuário cadastrado com sucesso! <a href='login.php'>Faça login</a>";
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}
?>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome Completo" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Cadastrar</button>
</form>
