<?php
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) { header("Location: /app/Views/login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Definir Previsões - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body class="login-page">
    <header class="main-header"><div class="header-content"><h1>🗓️ DEFINIR DATAS</h1></div></header>

    <main class="login-container" style="width: 100%; padding: 20px;">
        <div class="login-card" style="max-width: 800px; margin: 0 auto; text-align: left;">
            <h2 style="text-align: center;">Produtos Fora do Cardápio</h2>
            <p style="text-align: center; color: white; margin-bottom: 20px;">Adicione uma data para os itens indisponíveis.</p>

            <?php if (empty($produtos_indisponiveis)): ?>
                <p style="text-align: center; color: white;">Todos os produtos estão no cardápio atualmente!</p>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse; background: white; color: #333; border-radius: 8px; overflow: hidden;">
                    <tr style="background: #333; color: white;">
                        <th style="padding: 10px;">Produto</th>
                        <th style="padding: 10px;">Status Atual</th>
                        <th style="padding: 10px;">Nova Data</th>
                    </tr>
                    
                    <?php foreach ($produtos_indisponiveis as $prod): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;"><strong><?php echo $prod['nome_fruta']; ?></strong></td>
                        <td style="padding: 10px; color: #E53935; font-weight: bold;"><?php echo $prod['previsao']; ?></td>
                        <td style="padding: 10px; display: flex; gap: 10px; align-items: center;">
                            
                            <form action="/app/Controllers/salvar_previsao.php" method="POST" style="display: flex; gap: 5px; margin: 0;">
                                <input type="hidden" name="produto_id" value="<?php echo $prod['id']; ?>">
                                <input type="date" name="data_previsao" required style="padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                                <button type="submit" name="acao" value="salvar_data" style="background: #2e7d32; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Salvar Data</button>
                            </form>

                            <form action="/app/Controllers/salvar_previsao.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="produto_id" value="<?php echo $prod['id']; ?>">
                                <button type="submit" name="acao" value="sem_previsao" style="background: #E53935; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Mudar p/ "Sem Previsão"</button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>

            <div style="text-align: center; margin-top: 20px;">
                <a href="/app/Views/admin/painel.php" style="color: white; text-decoration: none; font-weight: bold;">← Voltar ao Painel</a>
            </div>
        </div>
    </main>
</body>
</html>