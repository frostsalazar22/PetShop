<?php
session_start();
include '../php/connection.php';

if (!isset($_GET['id'])) {
    die("ID do pet não foi informado.");
}

$petId = $_GET['id'];

// Buscar informações do pet na tabela PetAdocao
$stmt = $pdo->prepare("SELECT * FROM petadocao WHERE id = ?");
$stmt->execute([$petId]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    die("Pet não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info do Pet</title>
    <link rel="stylesheet" href="../css/pet_info.css">
</head>
<body>
    <header>
        <h1>Informações do Pet</h1>
    </header>
    <div class="container">
        <img src="../img/<?php echo htmlspecialchars($pet['imagem']); ?>" alt="<?php echo htmlspecialchars($pet['nome']); ?>" class="pet-img">
        
        <h2><?php echo htmlspecialchars($pet['nome']); ?></h2>

        <table class="pet-table">
            <tr><td><strong>Espécie</strong></td><td><?php echo htmlspecialchars($pet['especie']); ?></td></tr>
            <tr><td><strong>Idade</strong></td><td><?php echo htmlspecialchars($pet['idade']); ?> anos</td></tr>
            <tr><td><strong>Sexo</strong></td><td><?php echo htmlspecialchars($pet['sexo']); ?></td></tr>
            <tr><td><strong>Porte</strong></td><td><?php echo htmlspecialchars($pet['porte']); ?></td></tr>
            <tr><td><strong>Castrado</strong></td><td><?php echo $pet['castrado'] ? 'Sim' : 'Não'; ?></td></tr>
            <tr><td><strong>Vacinado</strong></td><td><?php echo $pet['vacinado'] ? 'Sim' : 'Não'; ?></td></tr>
            <tr><td><strong>Vermifugado</strong></td><td><?php echo $pet['vermifugado'] ? 'Sim' : 'Não'; ?></td></tr>
            <tr><td><strong>Cidade</strong></td><td><?php echo htmlspecialchars($pet['cidade']); ?></td></tr>
        </table>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <form action="../php/adopt_pet.php" method="POST">
                <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($pet['id']); ?>">
                <button type="submit" class="adopt-button">Adotar</button>
            </form>
        <?php else: ?>
            <p><strong>Faça login para adotar este pet.</strong></p>
            <a href="login_register.php"><button class="login-button">Login</button></a>
        <?php endif; ?>
    </div>
</body>
</html>
