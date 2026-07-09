<?php
session_start();
// Verifica segurança
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) { 
    header("Location: /app/Views/login.php"); 
    exit; 
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

$produtos_indisponiveis = $produto->listarForaDoCardapio();

require_once '../Views/admin/gerenciar_previsoes.php';
?>