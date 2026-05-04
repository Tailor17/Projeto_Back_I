<?php
session_start();

// Destrói apenas a variável do carrinho (mantendo o login do admin intacto, se for você testando)
if (isset($_SESSION['carrinho'])) {
    unset($_SESSION['carrinho']);
}

// Manda de volta para a tela principal com um aviso de sucesso
echo "<script>
        alert('Seu pedido foi encaminhado para o nosso WhatsApp! Obrigado por escolher a TDY Morangos 🍓');
        window.location.href = '/Projeto/index.php';
      </script>";
exit;
?>