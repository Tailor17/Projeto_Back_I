<?php
session_start();

if (isset($_SESSION['carrinho'])) {
    unset($_SESSION['carrinho']);
}

echo "<script>
        alert('Seu pedido foi encaminhado para o nosso WhatsApp! Obrigado por escolher a TDY Morangos 🍓');
        window.location.href = '/Projeto/index.php';
      </script>";
exit;
?>