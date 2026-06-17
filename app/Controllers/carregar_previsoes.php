<?php
session_start();
// Verifica segurança
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) { 
    header("Location: /app/Views/login.php"); 
    exit; 
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

// Prepara o banco e o model
$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

// Pede os dados para o Model
$produtos_indisponiveis = $produto->listarForaDoCardapio();

// Envia os dados prontinhos para a View desenhar a tela
require_once '../Views/admin/gerenciar_previsoes.php';
?>