<?php
session_start();

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: ../Views/login.php"); exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

if (isset($_GET['id']) && isset($_GET['previsao_atual'])) {
    $database = new Database();
    $db = $database->getConnection();
    $produto_model = new Produto($db);
    
    $produto_model->alternarDisponibilidade($_GET['id'], $_GET['previsao_atual']);
}

$pagina_anterior = $_SERVER['HTTP_REFERER'] ?? '/Projeto/painel.php';
header("Location: " . $pagina_anterior);
exit;
?>