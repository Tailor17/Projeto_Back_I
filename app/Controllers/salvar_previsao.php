<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) { header("Location: /app/Views/login.php"); exit; }

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['produto_id'])) {
    
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    $id = $_POST['produto_id'];

   
    if (isset($_POST['acao']) && $_POST['acao'] == 'sem_previsao') {
        $nova_previsao = "Sem previsão";
    } else {
        
        $data_formatada = date('d/m/Y', strtotime($_POST['data_previsao']));
        $nova_previsao = "Previsto para: " . $data_formatada;
    }

    if ($produto->atualizarPrevisao($id, $nova_previsao)) {
        echo "<script>alert('Status atualizado com sucesso!'); window.location.href = '/app/Controllers/carregar_previsoes.php';</script>";
    }
}
?>