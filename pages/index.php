<?php
include '../php/connection.php';

// Consultar todos os animais na tabela
$sql = "SELECT * FROM petadocao";
$query = $pdo->prepare($sql);
$query->execute();
$animais = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoção de Animais</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

    <header>
        <div class="logo">
            <h1>PetShop</h1>
        </div>
        <nav>
            <ul>
                <li><a href="adocao.php">Animais</a>
                    <ul>
                        <li><a href="">Cães para adoção</a></li>
                        <li><a href="">Gatos para adoção</a></li>
                        <li><a href="">Exóticos para adoção</a></li>
                    </ul>
                </li>
                <li><a href="#">Minha Conta</a>
                    <ul>
                        <li><a href="login_register.php">Entrar no site</a></li>
                        <li><a href="detalhes_conta.php">Detalhes da conta</a></li>
                        <li><a href="profile.php">Meus animais para adoção</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <h1>Animais para Adoção</h1>
    <div class="animal-list">
        <?php foreach ($animais as $animal): ?>
            <div class="animal-card">
                <img src="img/<?php echo $animal['imagem']; ?>" alt="Imagem de <?php echo $animal['nome']; ?>" class="animal-img">
                <h2><?php echo $animal['nome']; ?></h2>
                <p>Sexo: <?php echo $animal['sexo']; ?></p>
                <a href="pet_info.php?id=<?php echo $animal['id']; ?>" class="btn">Ver Ficha de Registro</a>
            </div>
        <?php endforeach; ?>
        
    </div>

</body>
</html>
