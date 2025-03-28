<?php
session_start();
include '../php/connection.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_register.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];


// Buscar informações do usuário
$stmtUser = $pdo->prepare("SELECT nome, email, telefone, cidade FROM Usuario WHERE id = ?");
$stmtUser->execute([$usuarioId]);
$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Erro: Usuário não encontrado no banco de dados.");
}

// Buscar os pets adotados pelo usuário
$stmtPets = $pdo->prepare("SELECT * FROM PetDono WHERE dono_id = ?");
$stmtPets->execute([$usuarioId]);
$pets = $stmtPets->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Centraliza o conteúdo */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
        }

        /* Estiliza a tabela */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .user-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 16px;
        }

        .user-table td:first-child {
            font-weight: bold;
            background-color: #f0f0f0;
            width: 30%;
        }

        /* Estiliza os cards dos pets */
        .pets-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 200px;
        }

        .card img {
            width: 100%;
            border-radius: 8px;
        }

        .card h3 {
            margin: 10px 0 5px;
        }

        .card p {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <h1>PetShop</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Animais</a></li>
            <li><a href="#">Minha Conta</a>
                <ul>
                    <li><a href="profile.php">Meu Perfil</a></li>
                    <li><a href="../php/logout.php">Sair</a></li>

                </ul>
            </li>
        </ul>
    </nav>
</header>

<div class="container">
    <?php if (isset($_GET['sucesso'])): ?>
        <p style="color: green; text-align: center;">Adoção realizada com sucesso!</p>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['erro']); ?></p>
    <?php endif; ?>

    <h2>Perfil do Usuário</h2>

    <table class="user-table">
        <tr><td>Nome</td><td><?php echo htmlspecialchars($usuario['nome']); ?></td></tr>
        <tr><td>E-mail</td><td><?php echo htmlspecialchars($usuario['email']); ?></td></tr>
        <tr><td>Telefone</td><td><?php echo htmlspecialchars($usuario['telefone']); ?></td></tr>
        <tr><td>Cidade</td><td><?php echo htmlspecialchars($usuario['cidade']); ?></td></tr>
    </table>

    <h2>Meus Pets Adotados</h2>
    <div class="pets-container">
        <?php if (count($pets) > 0): ?>
            <?php foreach ($pets as $pet): ?>
                <div class="card">
                    <img src="../img/<?php echo htmlspecialchars($pet['imagem']); ?>" alt="<?php echo htmlspecialchars($pet['nome']); ?>">
                    <h3><?php echo htmlspecialchars($pet['nome']); ?></h3>
                    <p>Espécie: <?php echo htmlspecialchars($pet['especie']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Você ainda não adotou nenhum pet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>