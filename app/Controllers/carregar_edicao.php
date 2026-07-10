<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: /app/Views/login.php"); exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    // Busca os dados da fruta específica
    $dados_produto = $produto->buscarPorId($_GET['id']);

    if($dados_produto) {
        require_once '../Views/admin/produto_editar.php';
    } else {
        echo "<script>alert('Produto não encontrado!'); window.location.href='/app/Controllers/listar_produtos.php';</script>";
    }
}
?>