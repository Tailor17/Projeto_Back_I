<?php
session_start();
require_once '../Config/Database.php';
require_once '../Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

$produtos_futuros = $produto->listarIndisponiveis();

require_once '../Views/cliente/previsoes.php';
?>