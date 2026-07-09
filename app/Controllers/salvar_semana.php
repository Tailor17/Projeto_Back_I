<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: /app/Views/login.php"); exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    $produto->zerarDisponibilidade();


    if (isset($_POST['produtos_selecionados'])) {
        $ids_marcados = $_POST['produtos_selecionados'];
        
        if ($produto->atualizarDisponibilidade($ids_marcados)) {
            echo "<script>alert('Cardápio da semana atualizado com sucesso!'); window.location.href = '/app/Views/admin/painel.php';</script>";
        } else {
            echo "<script>alert('Erro ao salvar as seleções no banco de dados.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Cardápio da semana zerado. A vitrine está vazia.'); window.location.href = '/app/Views/admin/painel.php';</script>";
    }
} else {
    header("Location: /app/Views/admin/painel.php");
}
?>