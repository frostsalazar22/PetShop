<?php
include '../php/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Buscar o usuário pelo hash do e-mail
        $emailToken = hash("sha256", $email);
        $stmt = $pdo->prepare("SELECT * FROM Usuario WHERE email = ?");
        $stmt->execute([$emailToken]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            session_start();
            $_SESSION['usuario_id'] = $user['id'];
            header("Location: profile.php");
            exit();
        } else {
            echo "E-mail ou senha inválidos.";
        }
    } elseif (isset($_POST['register'])) {
        include '../php/register.php';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Cadastro</title>
    <link rel="stylesheet" href="../css/login.css">
    </head>
<body>
    <div class="container">
        <div class="login">
            <h2>Login</h2>
            <form method="POST">
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit" name="login">Entrar</button>
            </form>
        </div>
        <div class="register">
            <h2>Cadastro</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <input type="text" name="telefone" placeholder="Telefone">
                <input type="text" name="cidade" placeholder="Cidade" required>
                <button type="submit" name="register">Cadastrar</button>
            </form>
        </div>
    </div>
</body>
</html>
