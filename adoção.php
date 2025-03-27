<?php
include 'conexao.php'; // Inclui a conexão com o banco

// Consultar todos os animais na tabela
$sql = "SELECT * FROM Animais";
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Cabeçalho com o menu de navegação -->
    <header>
        <div class="logo">
            <h1>PetShop</h1>
        </div>
        <nav>
            <ul>
                <li><a href="adocao.php">Animais</a>
                    <ul>
                        <li><a href="adocao.php?tipo=cao">Cães para adoção</a></li>
                        <li><a href="adocao.php?tipo=gato">Gatos para adoção</a></li>
                        <li><a href="adocao.php?tipo=exotico">Exóticos para adoção</a></li>
                    </ul>
                </li>
                <li><a href="#">Minha Conta</a>
                    <ul>
                        <li><a href="login.php">Entrar no site</a></li>
                        <li><a href="detalhes_conta.php">Detalhes da conta</a></li>
                        <li><a href="registrar.php">Registrar</a></li>
                        <li><a href="recuperar_senha.php">Perdi minha senha</a></li>
                        <li><a href="meus_animais.php">Meus animais para adoção</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <h1>Animais para Adoção</h1>
    <div class="animal-list">
        <?php foreach ($animais as $animal): ?>
            <div class="animal-card">
                <img src="images/<?php echo $animal['imagem']; ?>" alt="Imagem de <?php echo $animal['nome']; ?>" class="animal-img">
                <h2><?php echo $animal['nome']; ?></h2>
                <p>Sexo: <?php echo $animal['sexo']; ?></p>
                <a href="registro.php?id=<?php echo $animal['id']; ?>" class="btn">Ver Ficha de Registro</a>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
