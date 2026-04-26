<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: /app/Views/login.php"); exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

// Pega todas as frutas para mostrar na tela
$lista_produtos = $produto->listarTodos();

// Chama a View
require_once '../Views/admin/selecionar_semana.php';
?>