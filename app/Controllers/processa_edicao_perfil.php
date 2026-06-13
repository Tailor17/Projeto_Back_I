<?php
session_start();
require_once '../Config/Database.php';
require_once '../Models/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

$nova_senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;


if($usuario->atualizarPerfil(
    $_SESSION['usuario_id'], 
    $_POST['nome'], 
    $_POST['email'], 
    $_POST['telefone'], 
    $_POST['rua'], 
    $_POST['numero'], 
    $_POST['bairro'], 
    $_POST['cidade'], 
    $nova_senha
)) {
    $_SESSION['usuario_nome'] = $_POST['nome']; // Atualiza o nome na sessão também
    // Atualiza telefone e endereço na sessão para refletir mudanças no pedido
    $_SESSION['usuario_telefone'] = $_POST['telefone'] ?? '';
    $_SESSION['usuario_rua'] = $_POST['rua'] ?? '';
    $_SESSION['usuario_numero'] = $_POST['numero'] ?? '';
    $_SESSION['usuario_bairro'] = $_POST['bairro'] ?? '';
    $_SESSION['usuario_cidade'] = $_POST['cidade'] ?? '';
    echo "<script>alert('Perfil atualizado!'); window.location.href = '/index.php';</script>";
} else {
    echo "<script>alert('Erro ao atualizar.'); history.back();</script>";
}
}