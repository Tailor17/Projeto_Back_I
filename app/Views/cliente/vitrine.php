<?php
session_start(); 
$total_itens = 0;
if (isset($_SESSION['carrinho'])) {
    $total_itens = array_sum($_SESSION['carrinho']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>TDY Morangos - Cardápio da Sexta</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .vitrine-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; margin-top: 40px; padding: 0 20px; }
        .produto-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center; transition: 0.3s; display: flex; flex-direction: column; justify-content: space-between;}
        .produto-card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
        .produto-img { width: 100%; height: 220px; object-fit: cover; }
        .produto-info { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
        .produto-nome { font-size: 22px; color: #333; margin-bottom: 10px; }
        .produto-preco { font-size: 24px; font-weight: bold; color: #E53935; display: block; margin-bottom: 15px; }
        .btn-comprar { display: inline-block; background: #2e7d32; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: auto; }
        .btn-comprar:hover { background: #1b5e20; }
        .header-vitrine { background-color: #E53935; color: white; padding: 40px 20px; text-align: center; position: relative; }
        .btn-admin { position: absolute; top: 20px; right: 20px; color: white; border: 1px solid white; padding: 8px 15px; text-decoration: none; border-radius: 6px; font-size: 14px;}
        .btn-admin:hover { background: white; color: #E53935; }
        .btn-editar { position: absolute; top: 60px; right: 20px; color: white; border: 1px solid white; padding: 8px 15px; text-decoration: none; border-radius: 6px; font-size: 14px;}
        .btn-editar:hover { background: white; color: #E53935; }
        .btn-login { display: inline-block; margin-left: 12px; color: white; border: 1px solid white; padding: 8px 12px; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .btn-login:hover { background: white; color: #E53935; }
    </style>
</head>
<body style="background-color: #f5f6fa; font-family: Arial, sans-serif; margin: 0;">

        <header class="header-vitrine">
            <h1>🍓 TDY MORANGOS 🍓</h1>
            <p>Produtos frescos selecionados direto para a sua casa!</p>

            <div class="user-info" style="position: absolute; top: 20px; left: 20px; display: flex; align-items: center; gap: 10px;">
                <?php if (!empty($_SESSION['usuario_nome'])): ?>
                    <span>Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
                    <a href="/app/Controllers/logout.php" class="btn-login">Sair</a>
                <?php else: ?>
                    <span>Olá, visitante</span>
                    <a href="/app/Views/login.php" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
            
            <a href="/app/Views/cliente/carrinho.php" style="position: fixed; bottom: 20px; left: 20px; color: white; border: 1px solid white; padding: 8px 15px; text-decoration: none; border-radius: 6px; display: flex; align-items: center; gap: 8px; background: rgba(192, 52, 52, 0.7);">
                🛒 Carrinho 
                <?php if($total_itens > 0): ?>
                    <span style="background: #fff; color: #E53935; padding: 2px 8px; border-radius: 50%; font-weight: bold; font-size: 14px;">
                        <?php echo $total_itens; ?>
                    </span>
                <?php endif; ?>
            </a>

            <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1): ?>
                <a href="/app/Views/admin/painel.php" class="btn-admin">Ir para Painel</a>
            <?php else: ?>
                <a href="/app/Views/login.php" class="btn-admin">Área Admininstrativa</a>
            <?php endif; ?>

                <a href="/app/Controllers/carregar_edicao_usuario.php" class="btn-editar">Editar perfil</a>
        </header>
    <main style="max-width: 1200px; margin: 0 auto; padding-bottom: 60px;">
        
        <?php if (!empty($produtos_vitrine)): ?>
            <div class="vitrine-grid">
                <?php foreach ($produtos_vitrine as $item): ?>
                    
                    <div class="produto-card">
                        <?php if($item['foto_produto']): ?>
                            <img src="/public/uploads/produtos/<?php echo $item['foto_produto']; ?>" class="produto-img">
                        <?php else: ?>
                            <div style="width:100%; height:220px; background:#ddd; display:flex; align-items:center; justify-content:center; color:#888;">Sem Foto</div>
                        <?php endif; ?>
                        
                        <div class="produto-info">
                            <h2 class="produto-nome"><?php echo ucwords(strtolower($item['nome_fruta'])); ?></h2>
                            <span class="produto-preco">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></span>
                            <a href="/app/Controllers/adicionar_carrinho.php?id=<?php echo $item['id']; ?>" class="btn-comprar">
                                🛒 Adicionar ao Carrinho
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; margin-top: 80px;">
                <h2 style="color: #666;">Ops! O cardápio desta semana ainda não foi liberado.</h2>
                <p>Volte mais tarde ou entre em contato conosco pelo WhatsApp.</p>
            </div>
        <?php endif; ?>

    </main>

</body>
</html>