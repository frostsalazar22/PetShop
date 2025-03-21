<?php
require_once 'models/Animal.php';
$animal = new Animal();
$animais = $animal->listar();
?>

<h1>Animais para Adoção</h1>
<form method="GET">
    <input type="text" name="busca" placeholder="Pesquisar por raça ou tipo">
    <button type="submit">Buscar</button>
</form>

<ul>
    <?php
    if (isset($_GET['busca']) && !empty($_GET['busca'])) {
        $busca = strtolower($_GET['busca']);
        $filtrados = array_filter($animais, function($a) use ($busca) {
            return strpos(strtolower($a['raca']), $busca) !== false || strpos(strtolower($a['tipo']), $busca) !== false;
        });
    } else {
        $filtrados = $animais;
    }

    foreach ($filtrados as $a):
    ?>
        <li><?= $a['nome'] ?> - <?= $a['raca'] ?> (<?= $a['tipo'] ?>) - <a href="adotar.php?id=<?= $a['id'] ?>">Adotar</a></li>
    <?php endforeach; ?>
</ul>
