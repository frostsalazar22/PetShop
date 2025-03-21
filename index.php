<?php
require_once 'models/Animal.php';
$animal = new Animal();
$animais = $animal->listar();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Shop</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Bem-vindo ao Pet Shop</h1>
    <a href="login.php">Login</a> | <a href="adocao.php">Ver Animais</a>

    <h2>Animais para adoção</h2>
    <ul>
        <?php foreach ($animais as $a): ?>
            <li><?= $a['nome'] ?> - <?= $a['raca'] ?> (<?= $a['tipo'] ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
