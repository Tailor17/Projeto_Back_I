<?php
session_start();
require_once '../Config/Database.php';
require_once '../Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

// O Método 10 do seu Model já busca tudo que está fora do cardápio!
$produtos_futuros = $produto->listarIndisponiveis();

require_once '../Views/cliente/previsoes.php';
?>