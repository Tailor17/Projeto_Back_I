<?php
// setup.php - Execute este arquivo UMA VEZ para criar seu usuário Admin
require_once 'app/Config/Database.php';
require_once 'app/Models/Usuario.php';

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

$usuario->nome = "Tailor";
$usuario->email = "zitzketailor@gmail.com";
$usuario->senha = "12345";
$usuario->tipo_usuario = 1; // 1 = Admin

if($usuario->cadastrar()) {
    echo "<h1>Usuário Admin criado com sucesso!</h1>";
    echo "<p>Você já pode ir para a tela de login.</p>";
} else {
    echo "Erro ao criar usuário.";
}
?>