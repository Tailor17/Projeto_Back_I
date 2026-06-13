<?php
session_start();
require_once '../Config/Database.php';
require_once '../Models/Pedido.php';
require_once '../Models/Produto.php';
require_once '../Models/Usuario.php';

// 1. Define o endereço
$endereco_entrega = "";
if (isset($_POST['opcao_endereco']) && $_POST['opcao_endereco'] == 'padrao') {
    $endereco_entrega = $_POST['endereco_final_padrao'];
} else {
    $endereco_entrega = $_POST['nova_rua'] . ", " . $_POST['novo_numero'] . " - " . $_POST['novo_bairro'] . ", " . $_POST['nova_cidade'];
}

$database = new Database();
$db = $database->getConnection();
$produto_model = new Produto($db);
$pedido_model = new Pedido($db);

// 2. Calcula APENAS o valor total lendo a sessão
$valor_total = 0;
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $id => $qtd) {
        $dados = $produto_model->buscarPorId($id);
        if ($dados) {
            $valor_total += ($dados['preco'] * $qtd);
        }
    }
}

$nome_cliente = $_SESSION['usuario_nome'] ?? 'Cliente TDY'; 
$telefone_cliente = $_SESSION['usuario_telefone'] ?? null;
if ((empty($telefone_cliente) || $telefone_cliente === '') && isset($_SESSION['usuario_id'])) {
    $usuario_model = new Usuario($db);
    $dados_usuario = $usuario_model->buscarPorId($_SESSION['usuario_id']);
    $telefone_cliente = $dados_usuario['telefone'] ?? 'Não informado';
}
if (empty($telefone_cliente)) {
    $telefone_cliente = 'Não informado';
}

// 3. Salva o pedido principal e recebe o ID de volta
$id_novo_pedido = $pedido_model->criar($nome_cliente, $telefone_cliente, $valor_total, $endereco_entrega);

if ($id_novo_pedido) {
    // 4. Se o pedido principal salvou, faz o looping para salvar os itens!
    foreach ($_SESSION['carrinho'] as $id_produto => $qtd) {
        $dados = $produto_model->buscarPorId($id_produto);
        if ($dados) {
            // Salva na tabela itens_pedido ligando ao ID principal
            $pedido_model->adicionarItem($id_novo_pedido, $id_produto, $qtd, $dados['preco']);
        }
    }
    
    unset($_SESSION['carrinho']);
    
    echo "<script>
            alert('Seu pedido foi recebido com sucesso! Obrigado por escolher a TDY Morangos.'); 
            window.location.href='/Projeto/index.php';
          </script>";
} else {
    echo "<script>alert('Ocorreu um erro ao processar seu pedido.'); history.back();</script>";
}
?>