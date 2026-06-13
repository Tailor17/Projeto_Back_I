<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Pedidos - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .card-pedido { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: left; }
        .card-header { display: flex; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 15px; }
        .lista-itens { background: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 4px solid #E53935; }
        .lista-itens li { margin-bottom: 5px; list-style-type: none; }
        .btn-imprimir { background: #333; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; float: right; margin-bottom: 20px;}
        .botoes-topo { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        @media print {
            .esconder-na-impressao { 
                display: none !important; 
 
            }
            .botoes-topo {
                display: none !important;
            }
            body {
                background: white !important;
            }
            a{
                display: none !important;
            }
        }
    </style>
</head>
<body style="background:#f5f6fa; padding: 20px;">

    <div style="max-width: 900px; margin: 0 auto;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1>📦 Painel de Pedidos</h1>
        </div>
        
        <div class="botoes-topo">
            <a href="/app/Views/admin/painel.php" style="margin-right: 15px; color: #666; text-decoration: none;">Voltar ao Início</a>
            <button onclick="window.print()" class="btn-imprimir">🖨️ Imprimir Lista</button>
        </div>

        <?php if (empty($lista_pedidos)): ?>
            <p>Nenhum pedido recebido ainda.</p>
        <?php else: ?>
            
            <?php foreach ($lista_pedidos as $pedido): ?>
                <?php 
                
                $classe_impressao = (isset($pedido['status']) && $pedido['status'] == 'Entregue ✅') ? 'esconder-na-impressao' : '';
                ?>
                
                <div class="card-pedido <?php echo $classe_impressao; ?>">
                    
                    <div class="card-header">
                        <div>
                            <h3 style="margin: 0; color: #E53935;">Pedido #<?php echo $pedido['id']; ?></h3>
                            <small style="color: #888;">Realizado em: <?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></small>
                        </div>
                        <div style="text-align: right;">
                            <h2 style="margin: 0; color: #2e7d32;">R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></h2>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <strong>👤 Cliente:</strong><br>
                            <?php echo $pedido['nome_cliente']; ?><br>
                            📱 <?php echo $pedido['telefone_cliente']; ?>
                        </div>
                        <div style="flex: 2;">
                            <strong>📍 Endereço de Entrega:</strong><br>
                            <?php echo $pedido['endereco_entrega']; ?>
                        </div>
                    </div>

                    <div class="lista-itens" style="margin-bottom: 15px;">
                        <strong>Itens do Pedido:</strong>
                        <ul style="padding: 0; margin-top: 10px;">
                            <?php foreach ($pedido['itens'] as $item): ?>
                                <li>
                                    <span style="display:inline-block; width: 30px; font-weight:bold;"><?php echo $item['quantidade']; ?>x</span> 
                                    <?php echo ucwords(strtolower($item['nome_fruta'])); ?> 
                                    <span style="color:#666; font-size: 14px;">(R$ <?php echo number_format($item['preco_no_momento'], 2, ',', '.'); ?> un)</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div style="text-align: right; border-top: 1px solid #eee; padding-top: 10px;">
                        <p style="margin: 5px 0 10px 0; font-weight: bold; color: <?php echo (isset($pedido['status']) && $pedido['status'] == 'Entregue ✅') ? '#2e7d32' : '#E53935'; ?>">
                            Status: <?php echo $pedido['status'] ?? 'Pendente ⏳'; ?>
                        </p>
                        
                        <?php if (!isset($pedido['status']) || $pedido['status'] != 'Entregue ✅'): ?>
                            <a href="/app/Controllers/marcar_entregue.php?id=<?php echo $pedido['id']; ?>" style="background: #2196F3; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: bold;">📦 Marcar Entregue</a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</body>
</html>