<?php
session_start();
// Verifica se é administrador (tipo_usuario == 1)
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: ../Views/login.php"); exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto_model = new Produto($db);

// Se o Admin enviou o formulário atualizando uma previsão
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['produto_id'])) {
    $id = $_POST['produto_id'];
    $tipo = $_POST['tipo_previsao'];
    
    if ($tipo == 'data') {
        $data_formatada = date('d/m/Y', strtotime($_POST['data_previsao']));
        $nova_previsao = "Previsto para: " . $data_formatada;
    } else {
        $nova_previsao = $tipo; // "Sem previsão" ou "Disponível"
    }
    
    $produto_model->atualizarPrevisao($id, $nova_previsao);
    
    echo "<script>alert('Previsão atualizada com sucesso!'); window.location.href='admin_previsoes.php';</script>";
    exit;
}

// Busca a lista para mostrar na tela
$produtos_indisponiveis = $produto_model->listarIndisponiveis();

// Carrega a View
require_once '../Views/admin/gerenciar_previsoes.php';
?>