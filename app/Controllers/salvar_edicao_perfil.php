<?php 
session_start();

require_once '../Config/Database.php';
require_once '../Models/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    $usuario->id = $_SESSION['usuario_id'];
    $usuario->nome = $_POST['nome'];
    $usuario->email = $_POST['email'];
    $usuario->telefone = $_POST['telefone'];
    $usuario->rua = $_POST['rua'];
    $usuario->numero = $_POST['numero'];
    $usuario->bairro = $_POST['bairro'];
    $usuario->cidade = $_POST['cidade'];

    if(!empty($_POST['senha'])) {
        $usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    } else {
        $usuario->senha = "";
    }

    if($usuario->atualizarPerfil()) {
        $_SESSION['usuario_nome'] = $usuario->nome; 
        echo "<script>alert('Perfil atualizado!'); window.location.href = '/app/Views/cliente/vitrine.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar.'); history.back();</script>";
    }
}