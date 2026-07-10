<?php
session_start();

// 1. Proteção: Só o Admin pode excluir
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: /app/Views/login.php");
    exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

// 2. Verifica se o ID do produto foi enviado pela URL (método GET)
if (isset($_GET['id'])) {
    
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    $id_para_deletar = $_GET['id'];

    if ($produto->excluir($id_para_deletar)) {
        echo "<script>
                alert('Produto excluído com sucesso!');
                window.location.href = '/app/Controllers/listar_produtos.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao excluir o produto.');
                window.location.href = '/app/Controllers/listar_produtos.php';
              </script>";
    }
} else {
    header("Location: /app/Controllers/listar_produtos.php");
    exit;
}
?>