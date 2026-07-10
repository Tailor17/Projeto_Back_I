<?php

require_once 'app/Config/Database.php';
require_once 'app/Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

$produtos_vitrine = $produto->listarDisponiveisSemana();

require_once 'app/Views/cliente/vitrine.php';
?>