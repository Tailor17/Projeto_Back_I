<?php
session_start();

require_once '../Config/Database.php';
require_once '../Models/Usuario.php';

if (isset($_SESSION['usuario_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    $dados_usuario = $usuario->buscarPorId($_SESSION['usuario_id']);

    if($dados_usuario) {
        require_once '../Views/editar_perfil.php';
    } else {
        echo "<script>alert('Usuário não encontrado!'); window.location.href='/app/Views/login.php';</script>";
    }
} else {
    echo "<script>alert('Acesso negado!'); window.location.href='/app/Views/login.php';</script>";
}