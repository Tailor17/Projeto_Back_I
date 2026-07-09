<?php
session_start();

// Pega o ID da fruta
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]++;
    } else {
        $_SESSION['carrinho'][$id] = 1;
    }


    header('Content-Type: application/json');
    echo json_encode(['sucesso' => true, 'mensagem' => 'Produto adicionado']);
    exit();
}