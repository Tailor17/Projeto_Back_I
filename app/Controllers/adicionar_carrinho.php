<?php
session_start();

// Pega o ID da fruta
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Sua lógica atual de adicionar ao carrinho (exemplo):
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]++;
    } else {
        $_SESSION['carrinho'][$id] = 1;
    }

    // --- AQUI ESTÁ A MUDANÇA PARA O FETCH ---
    // Em vez de usar header("Location:..."), respondemos um JSON de sucesso:
    header('Content-Type: application/json');
    echo json_encode(['sucesso' => true, 'mensagem' => 'Produto adicionado']);
    exit();
}