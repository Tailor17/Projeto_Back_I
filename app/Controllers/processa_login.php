<?php

session_start(); 

require_once '../Config/Database.php';
require_once '../Models/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $database = new Database();
    $db = $database->getConnection();

    $usuario = new Usuario($db);

    $email_digitado = $_POST['email'];
    $senha_digitada = $_POST['senha'];

    if ($usuario->login($email_digitado, $senha_digitada)) {
        
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nome'] = $usuario->nome;
        // Armazena telefone e endereço para uso em pedidos
        $_SESSION['usuario_telefone'] = $usuario->telefone ?? '';
        $_SESSION['usuario_rua'] = $usuario->rua ?? '';
        $_SESSION['usuario_numero'] = $usuario->numero ?? '';
        $_SESSION['usuario_bairro'] = $usuario->bairro ?? '';
        $_SESSION['usuario_cidade'] = $usuario->cidade ?? '';
        $_SESSION['tipo_usuario'] = $usuario->tipo_usuario;

        if ($usuario->tipo_usuario == 1) {
            // É o Dono (Admin) -> Vai para o Painel de Controle
            header("Location: ../Views/admin/painel.php");
        } else {
            // É Cliente (0) -> Vai para a Vitrine de Frutas
            header("Location: /index.php");
        }
        exit;
        
    } else {
        echo "<script>
                alert('E-mail ou senha incorretos! Tente novamente.');
                window.location.href = '../Views/login.php';
              </script>";
    }
} else {
    header("Location: ../Views/login.php");
    exit;
}
?>