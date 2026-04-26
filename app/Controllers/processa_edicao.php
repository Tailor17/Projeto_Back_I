<?php
session_start();
require_once '../Config/Database.php';
require_once '../Models/Produto.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    $produto->id = $_POST['id'];
    $produto->nome_fruta = $_POST['nome_fruta'];
    $produto->preco = $_POST['preco'];

    // Verifica se uma NOVA foto foi enviada
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $pasta_destino = "../../public/uploads/produtos/";
        $nome_arquivo = time() . "_" . basename($_FILES["foto"]["name"]); 
        $caminho_completo = $pasta_destino . $nome_arquivo;

        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $caminho_completo)) {
            $produto->foto_produto = $nome_arquivo;
        }
    } else {
        // Se não enviou foto, deixamos vazio para o Model saber que não deve atualizar a imagem
        $produto->foto_produto = "";
    }

    if($produto->atualizar()) {
        echo "<script>alert('Produto atualizado!'); window.location.href = '/app/Controllers/listar_produtos.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar.'); history.back();</script>";
    }
}
?>