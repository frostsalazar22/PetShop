<?php
require_once 'models/Animal.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $animal = new Animal();
    $animal->cadastrar($_POST['nome'], $_POST['raca'], $_POST['tipo'], $_POST['genero'], $_POST['idade'], $_POST['dono_id']);
    echo "Animal cadastrado com sucesso!";
}
?>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome do Animal" required>
    <input type="text" name="raca" placeholder="Raça" required>
    <select name="tipo">
        <option value="gato">Gato</option>
        <option value="cachorro">Cachorro</option>
        <option value="pássaro">Pássaro</option>
        <option value="peixe">Peixe</option>
        <option value="lagarto">Lagarto</option>
        <option value="dinossauro">Dinossauro</option>
    </select>
    <select name="genero">
        <option value="Macho">Macho</option>
        <option value="Fêmea">Fêmea</option>
    </select>
    <input type="number" name="idade" placeholder="Idade" required>
    <input type="hidden" name="dono_id" value="1"> <!-- ID fixo por enquanto -->
    <button type="submit">Cadastrar</button>
</form>
