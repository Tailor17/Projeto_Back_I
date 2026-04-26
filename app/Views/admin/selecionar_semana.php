<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cardápio da Semana - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .grid-produtos { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
        .card-checkbox { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px; cursor: pointer; border: 2px solid transparent; transition: 0.3s;}
        .card-checkbox:hover { border-color: #E53935; }
        .card-checkbox img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; }
        .checkbox-custom { transform: scale(1.5); accent-color: #E53935; cursor: pointer; }
    </style>
</head>
<body class="login-page">

    <header class="main-header"><div class="header-content"><h1>CARDÁPIO DA SEXTA-FEIRA</h1></div></header>

    <main class="login-container" style="width: 100%; padding: 20px;">
    <div class="login-card" style="max-width: 900px; margin: 0 auto; text-align: left;">
            <h2 style="text-align:center;">Selecione os produtos disponíveis para venda</h2>
            
            <form action="/app/Controllers/salvar_semana.php" method="POST">
                
                <div class="grid-produtos">
                    <?php if (!empty($lista_produtos)): ?>
                        <?php foreach ($lista_produtos as $item): ?>
                            
                                            
                    <label class="card-checkbox">
                        <input type="checkbox" name="produtos_selecionados[]" value="<?php echo $item['id']; ?>" class="checkbox-custom" 
                            <?php echo ($item['disponivel_na_semana'] == 1) ? 'checked' : ''; ?>>
                        
                        <?php if($item['foto_produto']): ?>
                            <img src="/public/uploads/produtos/<?php echo $item['foto_produto']; ?>">
                        <?php endif; ?>
                        
                        <div style="display: flex; flex-direction: column;">
                            <strong style="color: black; font-size: 18px;">
                                <?php echo ucwords(strtolower($item['nome_fruta'])); ?>
                            </strong>
                            <span style="color:#2e7d32; font-weight:bold;">
                                R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                            </span>
                        </div>
                        </label>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align:center; width: 100%;">Nenhum produto cadastrado no sistema.</p>
                    <?php endif; ?>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn-entrar" style="max-width: 300px;">SALVAR CARDÁPIO</button>
                    <a href="/app/Views/admin/painel.php" style="display:block; margin-top:15px; color:white;">Voltar ao Painel</a>
                </div>
            </form>

        </div>
    </main>

</body>
</html>