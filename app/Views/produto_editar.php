<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body class="login-page">
    <header class="main-header"><div class="header-content"><h1>EDITAR FRUTA</h1></div></header>

    <main class="login-container">
        <div class="login-card">
            
            <form action="/app/Controllers/processa_edicao.php" method="POST" enctype="multipart/form-data" class="login-form">
                
                <input type="hidden" name="id" value="<?php echo $dados_produto['id']; ?>">

                <div class="form-group">
                    <label>Nome da Fruta</label>
                    <input type="text" name="nome_fruta" value="<?php echo $dados_produto['nome_fruta']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Preço (R$)</label>
                    <input type="number" step="0.01" name="preco" value="<?php echo $dados_produto['preco']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Foto Atual:</label>
                    <img src="/public/uploads/produtos/<?php echo $dados_produto['foto_produto']; ?>" style="width: 100px; border-radius: 8px; display: block; margin-bottom: 10px;">
                    
                    <label>Enviar Nova Foto (Opcional):</label>
                    <input type="file" name="foto" accept="image/*">
                </div>

                <button type="submit" class="btn-entrar" style="background-color: #f39c12; color: white;">SALVAR ALTERAÇÕES</button>
                <a href="/app/Controllers/listar_produtos.php" style="display:block; margin-top:15px; color:white;">Cancelar e Voltar</a>
                
            </form>
        </div>
    </main>
</body>
</html>