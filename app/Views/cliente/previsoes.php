<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Próximas Safras - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        .grid-vitrine { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; max-width: 1000px; margin: 0 auto; }
        .card-produto { background: white; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); opacity: 0.9; }
        .card-produto img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; filter: grayscale(20%); }
        .btn-previsoes { display: inline-block; margin-top: 10px; margin-bottom: 10px; color: white; border: 1px solid white; padding: 8px 12px; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .btn-previsoes:hover { background: white; color: #E53935; }
        .header-texto { text-align: center; color: #ffffff; margin-bottom: 10px; }
    </style>
</head>




<body;">
        <header class="main-header">
        <div class="header-texto">
            <h1>Previsão de Disponibilidade</h1>
            <p>Acompanhe o retorno dos nossos produtos que estão em cultivo.</p>
        </div>
            <div style="text-align: center; margin-bottom: 30px;">
        <a href="/index.php" class="btn-previsoes">🛒 Produtos Disponíveis</a>

    </div>
            
    </header>





    <div class="grid-vitrine">
        <?php if (empty($produtos_futuros)): ?>
            <p style="grid-column: 1 / -1; text-align: center; color: #666;">Todos os nossos produtos estão disponíveis para compra hoje!</p>
        <?php else: ?>
            <?php foreach ($produtos_futuros as $item): ?>
                <div class="card-produto">
                    <?php if($item['foto_produto']): ?>
                        <img src="/public/uploads/produtos/<?php echo $item['foto_produto']; ?>" alt="Foto">
                    <?php endif; ?>
                    
                    <h2 style="font-size: 20px; margin: 0 0 10px 0;"><?php echo $item['nome_fruta']; ?></h2>
                    
                    <div style="background: #fff3e0; border: 1px solid #ffb74d; padding: 10px; border-radius: 6px; margin-top: 15px;">
                        <span style="font-size: 20px;">📅</span>
                        <p style="margin: 5px 0 0 0; font-weight: bold; color: #e65100;">
                            <?php echo $item['previsao']; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>