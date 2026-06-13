<?php
session_start();
require_once '../Config/Database.php';
require_once '../Models/Produto.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $database = new Database();
    $db = $database->getConnection();
    $produto = new Produto($db);

    // Pega os dados de texto
    $produto->nome_fruta = $_POST['nome_fruta'];
    $produto->preco = $_POST['preco'];

    // LÓGICA DE UPLOAD DE ARQUIVO (Requisito 4)
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        
        $pasta_destino = "../../public/uploads/produtos/";
        // Cria um nome único para a imagem para não sobrepor outras (Ex: 1698543_morango.jpg)
        $nome_arquivo = time() . "_" . basename($_FILES["foto"]["name"]); 
        $caminho_completo = $pasta_destino . $nome_arquivo;

        // Move o arquivo temporário para a pasta definitiva
        if(move_uploaded_file($_FILES["foto"]["tmp_name"], $caminho_completo)) {
            
            // Se o upload deu certo, salva apenas o nome no banco de dados
            $produto->foto_produto = $nome_arquivo;

            // Chama o Model para gravar no banco
            if($produto->cadastrar()) {
                echo "<script>
                        alert('Produto cadastrado com sucesso!');
                        window.location.href = '/app/Controllers/listar_produtos.php';
                      </script>";
            } else {
                echo "Erro ao salvar no banco de dados.";
            }

        } else {
            echo "<script>alert('Erro ao fazer upload da imagem.'); history.back();</script>";
        }
    } else {

        echo "<script>alert('Selecione uma imagem válida.'); history.back();</script>";
    }
}
?>