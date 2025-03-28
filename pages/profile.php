<?php
session_start();
include '../php/connection.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_register.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT * FROM PetDono WHERE dono_id = ?");
$stmt->execute([$usuarioId]);
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Meus Pets Adotados</h1>
    </header>
    <div class="container">
        <?php foreach ($pets as $pet): ?>
            <div class="card">
                <img src="images/<?php echo $pet['imagem']; ?>" alt="<?php echo $pet['nome']; ?>" width="200">
                <h3><?php echo $pet['nome']; ?></h3>
                <p>Espécie: <?php echo $pet['especie']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
