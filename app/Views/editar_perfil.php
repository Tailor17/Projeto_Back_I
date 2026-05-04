<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body class="login-page">
    <header class="main-header"><div class="header-content"><h1>EDITAR PERFIL</h1></div></header>

    <main class="login-container">
        <div class="login-card">
            <form action="/app/Controllers/processa_edicao_perfil.php" method="POST" class="login-form">
                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" name="nome" value="<?php echo $dados_usuario['nome']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $dados_usuario['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="telefone" value="<?php echo $dados_usuario['telefone']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Rua</label>
                    <input type="text" name="rua" value="<?php echo $dados_usuario['rua']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Número</label>
                    <input type="text" name="numero" value="<?php echo $dados_usuario['numero']; ?>" required>  
                </div>
                <div class="form-group">
                    <label>Bairro</label>
                    <input type="text" name="bairro" value="<?php echo $dados_usuario['bairro']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Cidade</label>
                    <input type="text" name="cidade" value="<?php echo $dados_usuario['cidade']; ?>" required>  
                </div> 
                <div class="form-group">
                    <label>Nova Senha (deixe em branco para manter a atual)</label>
                    <input type="password" name="senha">
                </div>
                <button type="submit" class="btn-entrar" style="background-color: #f39c12; color: white;">SALVAR ALTERAÇÕES</button>
                <a href="/app/Controllers/listar_produtos.php" style="display:block; margin-top:15px; color:white;">Cancelar e Voltar</a>
            </form>
        </div>
    </main>
</body>
</html>
