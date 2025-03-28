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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Informações do Pet</h1>
    </header>
    <div class="container">
        <img src="img/<?php echo htmlspecialchars($pet['imagem']); ?>" alt="<?php echo htmlspecialchars($pet['nome']); ?>" width="300">
        <h2><?php echo htmlspecialchars($pet['nome']); ?></h2>
        <p>Espécie: <?php echo htmlspecialchars($pet['especie']); ?></p>
        <p>Idade: <?php echo htmlspecialchars($pet['idade']); ?> anos</p>
        <p>Sexo: <?php echo htmlspecialchars($pet['sexo']); ?></p>
        <p>Porte: <?php echo htmlspecialchars($pet['porte']); ?></p>
        <p>Castrado: <?php echo $pet['castrado'] ? 'Sim' : 'Não'; ?></p>
        <p>Vacinado: <?php echo $pet['vacinado'] ? 'Sim' : 'Não'; ?></p>
        <p>Vermifugado: <?php echo $pet['vermifugado'] ? 'Sim' : 'Não'; ?></p>
        <p>Cidade: <?php echo htmlspecialchars($pet['cidade']); ?></p>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <form action="./php/adopt_pet.php" method="POST">
                <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                <button type="submit">Adotar</button>
            </form>
        <?php else: ?>
            <p><strong>Faça login para adotar este pet.</strong></p>
            <a href="./pages/login_register.php"><button>Login</button></a>
        <?php endif; ?>
    </div>
</body>
</html>
