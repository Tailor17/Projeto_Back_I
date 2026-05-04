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
    echo "<script>alert('Perfil atualizado!'); window.location.href = '/index.php';</script>";
} else {
    echo "<script>alert('Erro ao atualizar.'); history.back();</script>";
}
}