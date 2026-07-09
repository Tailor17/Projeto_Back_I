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
    <title>TDY Morangos - Cardápio</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .vitrine-grid { display: grid; grid-template-columns: repeat(auto-fill, 250px); gap: 20px; max-width: 1000px; margin: 0 auto; justify-content: center; }
        .produto-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: 0.3s; display: flex; flex-direction: column; gap: 0; text-align: left; }
        .produto-card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
        .produto-img { width: 100%; aspect-ratio: 4 / 3; object-fit: cover; }
        .produto-info { padding: 20px; display: flex; flex-direction: column; justify-content: space-between; flex: 1; min-height: 100%; }
        .produto-details { display: flex; flex-direction: column; gap: 12px; }
        .produto-nome { font-size: 22px; color: #333; margin-bottom: 0; }
        .produto-preco { font-size: 24px; font-weight: bold; color: #E53935; display: block; margin-bottom: 0; }
        .produto-actions { margin-top: 20px; display: flex; justify-content: center; }
        .btn-comprar { display: inline-flex; align-items: center; justify-content: center; background: #2e7d32; color: white; padding: 12px 16px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; width: 100%; max-width: 220px; border: none; cursor: pointer; }
        .btn-comprar:hover { background: #1b5e20; }
        .header-vitrine { background-color: #E53935; color: white; padding: 40px 20px; text-align: center; position: relative; }
        .btn-admin { position: absolute; top: 20px; right: 20px; color: white; border: 1px solid white; padding: 8px 15px; text-decoration: none; border-radius: 6px; font-size: 14px;}
        .btn-admin:hover { background: white; color: #E53935; }
        .btn-editar { position: absolute; top: 60px; right: 20px; color: white; border: 1px solid white; padding: 8px 15px; text-decoration: none; border-radius: 6px; font-size: 14px; margin-top: 10px;}
        .btn-editar:hover { background: white; color: #E53935; }
        .user-info { position: absolute; top: 20px; left: 20px; display: flex; flex-direction: column; align-items: flex-start; gap: 8px; color: white; }
        .user-info span { color: white; }
        .btn-login { color: white; border: 1px solid white; padding: 8px 12px; text-decoration: none; border-radius: 6px; font-size: 14px;}
        .btn-login:hover { background: white; color: #E53935; }
        .btn-previsoes { display: inline-block; color: white; border: 1px solid white; padding: 8px 12px; text-decoration: none; border-radius: 6px; font-size: 14px;}
        .btn-previsoes:hover { background: white; color: #E53935;}

        @media (max-width: 900px) {
            .vitrine-grid { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        }
        @media (max-width: 720px) {
            .vitrine-grid { grid-template-columns: 1fr; gap: 18px; }
            .produto-card { flex-direction: column; }
            .produto-img { width: 100%; height: 220px; min-width: auto; }
        }
    </style>
</head>
<body style="background-color: #f5f6fa; font-family: Arial, sans-serif; margin: 0;">

        <header class="header-vitrine" style="margin-bottom: 40px;">
            <h1>🍓 TDY MORANGOS 🍓</h1>
            <p>Produtos frescos selecionados direto para a sua casa!</p>

            <div class="user-info">
                <?php if (!empty($_SESSION['usuario_nome'])): ?>
                    <span>Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
                    <a href="/app/Controllers/logout.php" class="btn-login">Sair</a>
                <?php else: ?>
                    <span>Olá, visitante</span>
                    <a href="/app/Views/login.php" class="btn-login">Login</a>
                <?php endif; ?>
                <a href="/app/Controllers/vitrine_previsoes.php" class="btn-previsoes">Itens Indisponíveis</a>
            </div>
            
            <a id="contador-carrinho-container" href="/app/Views/cliente/carrinho.php" style="position: fixed; bottom: 20px; left: 20px; color: white; border: 1px solid white; padding: 8px 15px; text-decoration: none; border-radius: 6px; display: flex; align-items: center; gap: 8px; background: rgba(192, 52, 52, 0.7); z-index: 1000;">
                🛒 Carrinho 
                <span id="contador-numero" style="background: #fff; color: #E53935; padding: 2px 8px; border-radius: 50%; font-weight: bold; font-size: 14px; display: <?php echo ($total_itens > 0) ? 'inline-block' : 'none'; ?>;">
                    <?php echo $total_itens; ?>
                </span>
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
                            <div class="produto-details">
                                <h2 class="produto-nome"><?php echo ucwords(strtolower($item['nome_fruta'])); ?></h2>
                                <span class="produto-preco">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></span>
                                <?php 
                                    if ($item['previsao'] == 'Disponível') {
                                        $cor_status = '#2e7d32'; 
                                        $icone_status = '✅';
                                    } elseif ($item['previsao'] == 'Sem previsão') {
                                        $cor_status = '#E53935'; 
                                        $icone_status = '🚫';
                                    } else {
                                        $cor_status = '#FF9800'; 
                                        $icone_status = '⏳';
                                    }
                                    ?>
                                    
                                    <p style="color: <?php echo $cor_status; ?>; font-weight: bold; font-size: 14px; margin: 10px 0;">
                                        <?php echo $icone_status . ' ' . $item['previsao']; ?>
                                    </p>

                                    <?php if ($item['previsao'] == 'Disponível'): ?>
                                        <button data-id="<?php echo $item['id']; ?>" class="btn-comprar btn-ajax-carrinho">Adicionar ao Carrinho</button>
                                    <?php else: ?>
                                        <button disabled style="background: #ccc; color: #666; width: 100%; padding: 10px; border: none; border-radius: 4px; cursor: not-allowed; font-weight: bold;">Indisponível no momento</button>
                                    <?php endif; ?>
                            </div>
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

    <script>
    document.querySelectorAll('.btn-ajax-carrinho').forEach(botao => {
        botao.addEventListener('click', function() {
            const produtoId = this.getAttribute('data-id');
            
            
            const textoOriginal = this.innerText;
            this.innerText = "Adicionando...";
            this.disabled = true;

            // Faz o fetch enviando segundo plano
            fetch(`/app/Controllers/adicionar_carrinho.php?id=${produtoId}`, {
                method: 'GET' 
            })
            .then(response => {
                if (response.ok) {
                    this.innerText = "Adicionado! 🍓";
                    this.style.backgroundColor = "#155724"; // Verde escuro de sucesso
                    
                    
                    const contadorNum = document.getElementById('contador-numero');
                    let quantidadeAtual = parseInt(contadorNum.innerText) || 0;
                    quantidadeAtual += 1;
                    
                    contadorNum.innerText = quantidadeAtual;
                    contadorNum.style.display = 'inline-block'; 

                    
                    setTimeout(() => {
                        this.innerText = textoOriginal;
                        this.style.backgroundColor = "#2e7d32";
                        this.disabled = false;
                    }, 1500);

                } else {
                    alert("Erro ao adicionar produto.");
                    this.innerText = textoOriginal;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error("Erro:", error);
                alert("Ocorreu um erro de conexão.");
                this.innerText = textoOriginal;
                this.disabled = false;
            });
        });
    });
    </script>
</body>
</html>