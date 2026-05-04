<?php
session_start();
require_once '../Config/Database.php';
require_once '../Models/Pedido.php';

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $pedido_model = new Pedido($db);
    
    // Atualiza o status para Entregue
    $pedido_model->atualizarStatus($_GET['id'], 'Entregue ✅');
}

// Volta para a tela de pedidos automaticamente
header("Location: /app/Controllers/listar_pedidos.php");
exit;
?>