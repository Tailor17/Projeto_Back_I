<?php
session_start();
// Proteção de segurança
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: ../Views/login.php"); exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

if (isset($_GET['id']) && isset($_GET['previsao_atual'])) {
    $database = new Database();
    $db = $database->getConnection();
    $produto_model = new Produto($db);
    
    // Dispara a automação
    $produto_model->alternarDisponibilidade($_GET['id'], $_GET['previsao_atual']);
}

// Volta instantaneamente para a tela de onde o admin clicou
// O HTTP_REFERER garante que se você clicar na tela de Produtos, volta pra lá.
$pagina_anterior = $_SERVER['HTTP_REFERER'] ?? '/Projeto/painel.php';
header("Location: " . $pagina_anterior);
exit;
?>