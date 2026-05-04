<?php
session_start();

$id = $_GET['id'] ?? null;
$acao = $_GET['acao'] ?? '';

if ($acao == 'limpar') {
    unset($_SESSION['carrinho']);
} 
elseif ($id) {
    switch ($acao) {
        case 'add':
            $_SESSION['carrinho'][$id]++;
            break;
        case 'sub':
            if ($_SESSION['carrinho'][$id] > 1) {
                $_SESSION['carrinho'][$id]--;
            } else {
                unset($_SESSION['carrinho'][$id]);
            }
            break;
        case 'del':
            unset($_SESSION['carrinho'][$id]);
            break;
    }
}

header("Location: ../Views/cliente/carrinho.php");
exit;