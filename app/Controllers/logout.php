<?php
session_start();

// Limpa todas as variáveis da sessão (carrinho, login, tudo)
session_unset(); 

// Destrói a sessão no servidor
session_destroy(); 

// Redireciona para a página inicial (Vitrine)
header("Location: /index.php");
exit;
?>