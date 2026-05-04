<?php
session_start();

// Se o carrinho ainda não existir na sessão, nós o criamos como um array vazio
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

// Pegamos o ID que veio pelo botão
if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];

    // Se o produto já estiver no carrinho, aumentamos a quantidade
    if (isset($_SESSION['carrinho'][$id_produto])) {
        $_SESSION['carrinho'][$id_produto] += 1;
    } else {
        // Se for a primeira vez que adiciona esse produto, a quantidade é 1
        $_SESSION['carrinho'][$id_produto] = 1;
    }
}

// Redireciona de volta para a vitrine para o cliente continuar comprando
header("Location: /index.php"); 
exit;