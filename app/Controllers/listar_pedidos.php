<?php
session_start();
// Verifica se é administrador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: ../Views/login.php"); exit;
}

require_once '../Config/Database.php';
require_once '../Models/Pedido.php';

$database = new Database();
$db = $database->getConnection();
$pedido_model = new Pedido($db);

// Busca os pedidos e prepara um array completo
$pedidos_brutos = $pedido_model->listarTodos();
$lista_pedidos = [];

foreach ($pedidos_brutos as $pedido) {
    // Para cada pedido, busca as frutas que a pessoa comprou
    $itens = $pedido_model->buscarItens($pedido['id']);
    $pedido['itens'] = $itens; // Guarda os itens dentro do array do pedido
    $lista_pedidos[] = $pedido;
}

// Carrega a View passando a lista completa
require_once '../Views/admin/pedidos_lista.php';
?>