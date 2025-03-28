<?php
include '../php/connection.php';

// Função para buscar cidades do IBGE
function obterCidadesIBGE() {
    $url = "https://servicodados.ibge.gov.br/api/v1/localidades/municipios";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $dados = json_decode($response, true);
    if (!is_array($dados)) {
        return [];
    }

    return array_map(function ($cidade) {
        return $cidade["nome"];
    }, $dados);
}

// Obtém a lista de cidades válidas
$cidadesValidas = obterCidadesIBGE();

// Função para validar nomes reais
function validarNome($nome) {
    $nome = trim($nome);
    return !empty($nome) && preg_match("/^[A-ZÁÉÍÓÚÂÊÎÔÛÄËÏÖÜÇ][a-záéíóúâêîôûäëïöüç]+(?: [A-ZÁÉÍÓÚÂÊÎÔÛÄËÏÖÜÇ][a-záéíóúâêîôûäëïöüç]+)*$/", $nome);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];

    // Validação do nome
    if (!validarNome($nome)) {
        die("Nome inválido. Use um nome real com iniciais maiúsculas.");
    }

    // Validação do telefone (apenas números, entre 8 e 15 dígitos)
    if (!preg_match("/^\d{8,15}$/", $telefone)) {
        die("Telefone inválido. Deve conter apenas números (8 a 15 dígitos).");
    }

    // Validação do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("E-mail inválido.");
    }

    // Validação da cidade
    if (!in_array($cidade, $cidadesValidas)) {
        die("Cidade inválida. Escolha uma cidade válida.");
    }

    // Criar tokens para e-mail, telefone e cidade
    $emailToken = hash("sha256", $email);
    $telefoneToken = hash("sha256", $telefone);
    $cidadeToken = hash("sha256", $cidade);

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO Usuario (nome, email, senha, telefone, cidade) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $emailToken, $senhaHash, $telefoneToken, $cidadeToken]);

        echo "Cadastro realizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>