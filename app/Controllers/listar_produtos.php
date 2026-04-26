<?php
session_start();

// Proteção da página
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: /app/Views/login.php");
    exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

// Chama o método que criamos no Model para pegar todas as frutas
$lista_produtos = $produto->listarTodos();


// Agora que temos a lista salva na variável $lista_produtos, 
// nós "incluímos" o arquivo HTML (View) para que ele possa usar essa variável.
require_once '../Views/admin/produtos_lista.php';
?>