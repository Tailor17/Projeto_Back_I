<?php
session_start();
require_once '../../Config/Database.php';
require_once '../../Models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$produto_model = new Produto($db);

$itens_carrinho = array();
$total_pedido = 0;

// Se houver algo no carrinho, buscamos os detalhes de cada produto no banco
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $id => $qtd) {
        $dados = $produto_model->buscarPorId($id);
        if ($dados) {
            $dados['quantidade'] = $qtd;
            $dados['subtotal'] = $dados['preco'] * $qtd;
            $itens_carrinho[] = $dados;
            $total_pedido += $dados['subtotal'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body style="background:#f5f6fa; padding: 20px;">
    <div class="login-card" style="max-width: 800px; margin: 0 auto; text-align: left;">
        <h1>🛒 Meu Carrinho</h1>

        <?php if (empty($itens_carrinho)): ?>
            <p style="text-align: center; font-size: 18px; margin: 40px 0;">Seu carrinho está vazio.</p>
            <div style="text-align: center;">
                <a href="/index.php" class="btn-entrar" style="display:inline-block; max-width:200px; text-decoration:none;">Voltar para a vitrine</a>
            </div>
        <?php else: ?>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; text-align: left;">
                        <th style="padding: 10px;">Produto</th>
                        <th style="padding: 10px;">Qtd</th>
                        <th style="padding: 10px;">Preço Unit.</th>
                        <th style="padding: 10px;">Subtotal</th>
                        <th style="padding: 10px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens_carrinho as $item): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;"><?php echo ucwords(strtolower($item['nome_fruta'])); ?></td>
                        
                        <td style="padding: 10px; display: flex; align-items: center; gap: 10px;">
                            <a href="/app/Controllers/alterar_quantidade.php?id=<?php echo $item['id']; ?>&acao=sub" style="text-decoration:none; background:#ddd; padding:4px 10px; border-radius:4px; color:#333; font-weight:bold;">-</a>
                            <strong><?php echo $item['quantidade']; ?></strong>
                            <a href="/app/Controllers/alterar_quantidade.php?id=<?php echo $item['id']; ?>&acao=add" style="text-decoration:none; background:#ddd; padding:4px 10px; border-radius:4px; color:#333; font-weight:bold;">+</a>
                        </td>
                        
                        <td style="padding: 10px;">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td style="padding: 10px; font-weight:bold;">R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                        <td style="padding: 10px;">
                            <a href="/app/Controllers/alterar_quantidade.php?id=<?php echo $item['id']; ?>&acao=del" style="color:#E53935; font-size:14px; font-weight:bold; text-decoration:none;">Remover</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>

            <div style="text-align: right; border-top: 2px solid #eee; padding-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <a href="/app/Controllers/alterar_quantidade.php?acao=limpar" style="color: #666; font-size: 14px; text-decoration: none; font-weight:bold;">🧹 Limpar Carrinho</a>
                    <h2 style="color: #333; margin: 0;">Total: <span style="color: #2e7d32;">R$ <?php echo number_format($total_pedido, 2, ',', '.'); ?></span></h2>
                </div>
                
                <a href="/index.php" style="color: #666; margin-right: 20px; text-decoration: none;">Continuar Comprando</a>
                <a href="/app/Views/cliente/finalizar_pedido.php" class="btn-entrar" style="display: inline-block; text-decoration: none; text-align: center; max-width: 280px; padding: 12px;">PROSSEGUIR PARA ENTREGA</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>