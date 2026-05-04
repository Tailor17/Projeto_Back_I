<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto - Admin</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body class="login-page">

    <div class="login-container">
        <div class="login-card">
            <h2>✏️ Editar Produto</h2>
            
            <form action="/app/Controllers/salvar_edicao.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $dados_produto['id']; ?>">

                <div class="form-group">
                    <label>Nome do Produto</label>
                    <input type="text" name="nome_fruta" value="<?php echo $dados_produto['nome_fruta']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Preço (R$)</label>
                    <input type="number" step="0.01" name="preco" value="<?php echo $dados_produto['preco']; ?>" required>
                </div>

                <div class="form-group">
                    <input type="hidden" name="foto_produto" value="<?php echo $dados_produto['foto_produto']; ?>">

                <div class="input-group">
                    <label>Mudar foto (opcional)</label>
                    <label>Foto Atual</label>
                    <img src="/public/uploads/produtos/<?php echo $dados_produto['foto_produto']; ?>" style="width:100%; max-width:200px; margin-bottom:10px; display: block; margin-left: auto; margin-right: auto;">
                    <input type="file" name="foto_nova">
                </div>
                </div>

                <button type="submit" class="btn-entrar">SALVAR ALTERAÇÕES</button>
            </form>
            
            <a href="/app/Controllers/listar_produtos.php" style="display:block; text-align:center; margin-top:15px; color:#666;">Voltar para Lista</a>
        </div>
    </div>

</body>
</html>