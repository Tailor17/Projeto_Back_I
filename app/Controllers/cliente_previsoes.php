<?php
session_start();
require_once '../Config/Database.php';
require_once '../Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto_model = new Produto($db);

$produtos_futuros = $produto_model->listarIndisponiveis();

require_once '../Views/cliente/aba_previsoes.php';
?>