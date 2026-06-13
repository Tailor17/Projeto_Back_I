<?php

require_once 'app/Config/Database.php';
require_once 'app/Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

// Busca no banco APENAS as frutas que marquei com a caixinha no painel
$produtos_vitrine = $produto->listarDisponiveisSemana();

// Chama a tela da vitrine
require_once 'app/Views/cliente/vitrine.php';
?>