<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body style="background:#f5f6fa; padding: 20px; display: flex; justify-content: center;">
    
    <div class="login-card" style="max-width: 500px; width: 100%; text-align: left;">
        <h1 style="text-align: center; color: #E53935;">🍓 Novo Cadastro</h1>
        <p style="text-align: center; margin-bottom: 20px;">Crie sua conta para fazer pedidos deliciosos!</p>

        <form action="/app/Controllers/processar_cadastro.php" method="POST">
            
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Nome Completo</label>
            <input type="text" name="nome" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:4px;">

            <label style="display:block; font-weight:bold; margin-bottom:5px;">E-mail</label>
            <input type="email" name="email" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:4px;">

            <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Senha</label>
                    <input type="password" name="senha" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">WhatsApp / Telefone</label>
                    <input type="text" name="telefone" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:4px;">
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="font-weight: bold; color: #333; margin-bottom: 15px;">Endereço de Entrega</p>

            <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                <div style="flex: 3;">
                    <label style="display:block; font-size:14px; margin-bottom:5px;">Rua/Avenida</label>
                    <input type="text" name="rua" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; font-size:14px; margin-bottom:5px;">Número</label>
                    <input type="text" name="numero" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-bottom: 25px;">
                <div style="flex: 1;">
                    <label style="display:block; font-size:14px; margin-bottom:5px;">Bairro</label>
                    <input type="text" name="bairro" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; font-size:14px; margin-bottom:5px;">Cidade</label>
                    <input type="text" name="cidade" value="São Lourenço do Sul" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                </div>
            </div>

            <button type="submit" class="btn-entrar" style="width: 100%; padding: 12px; font-size: 16px;">CADASTRAR E ENTRAR</button>
            
            <div style="text-align: center; margin-top: 15px;">
                <a href="/app/Views/login.php" style="color: #666; text-decoration: none;">Já tenho conta. Voltar ao Login.</a>
            </div>
        </form>
    </div>
</body>
</html>