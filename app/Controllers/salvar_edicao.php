<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: ../Views/login.php"); exit;
}

require_once '../Config/Database.php';
require_once '../Models/Produto.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    $id = $_POST['id'];
    $nome = $_POST['nome_fruta'];
    $preco = $_POST['preco'];
    $foto_final = $_POST['foto_produto'];

    if(isset($_FILES['foto_nova']) && $_FILES['foto_nova']['error'] === UPLOAD_ERR_OK) {
        $pasta_destino = "../../public/uploads/produtos/";
        $nome_arquivo = time() . "_" . basename($_FILES["foto_nova"]["name"]); 
        $caminho_completo = $pasta_destino . $nome_arquivo;

        if(move_uploaded_file($_FILES["foto_nova"]["tmp_name"], $caminho_completo)) {
            $foto_final = $nome_arquivo; // Atualiza a variável para salvar o novo nome no banco
        } else {
            echo "<script>alert('Erro ao fazer upload da nova imagem.'); history.back();</script>";
            exit;
        }
    }
    

    if ($produto->atualizar($id, $nome, $preco, $foto_final)) {
        echo "<script>alert('Produto editado com sucesso!'); window.location.href = 'listar_produtos.php';</script>";
    } else {
        echo "<script>alert('Erro ao editar.'); history.back();</script>";
    }
}
?>