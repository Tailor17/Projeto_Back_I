<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body class="login-page"> <header class="main-header">
        <div class="header-content">
            <h1>CADASTRAR NOVA FRUTA</h1>
        </div>
    </header>

    <main class="login-container">
        <div class="login-card">
            
            <form action="/app/Controllers/processa_produto.php" method="POST" enctype="multipart/form-data" class="login-form">
                
                <div class="form-group">
                    <label for="nome_fruta">Nome da Fruta</label>
                    <input type="text" id="nome_fruta" name="nome_fruta" placeholder="Ex: Morango Bandeja 250g" required>
                </div>

                <div class="form-group">
                    <label for="preco">Preço (R$)</label>
                    <input type="number" step="0.01" id="preco" name="preco" placeholder="Ex: 15.50" required>
                </div>

                <div class="form-group">
                    <label for="foto">Foto do Produto</label>
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                </div>

                <button type="submit" class="btn-entrar">SALVAR PRODUTO</button>
                <a href="/app/Views/admin/painel.php" style="display:block; margin-top:15px; color:white;">Voltar ao Painel</a>
                
            </form>
        </div>
    </main>

</body>
</html>