<?php
session_start();
require_once '../../Config/Database.php';
require_once '../../Models/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php?msg=faca_login_para_finalizar");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);
$dados_usuario = $usuario->buscarPorId($_SESSION['usuario_id']);

// Simulação: Buscando dados do banco (na prática, use seu Model Usuario)
$nome_usuario = $_SESSION['usuario_nome'];
$endereco_padrao = $dados_usuario['rua'] . ", " . $dados_usuario['numero'] . " - " . $dados_usuario['bairro'] . ", " . $dados_usuario['cidade']; // Isso viria do seu SELECT no banco
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Pedido - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <script>
    function toggleEndereco(valor) {
        const campoNovo = document.getElementById('campo_novo_endereco');
        // Lista dos novos campos que precisamos tornar obrigatórios
        const campos = ['nova_rua', 'novo_numero', 'novo_bairro']; 
        
        if (valor === 'novo') {
            campoNovo.style.display = 'block';
            campos.forEach(id => document.getElementById(id).required = true);
        } else {
            campoNovo.style.display = 'none';
            campos.forEach(id => document.getElementById(id).required = false);
        }
    }
</script>
</head>
<body style="background:#f5f6fa; padding: 20px;">
    <div class="login-card" style="max-width: 600px; margin: 0 auto; text-align: left;">
        <h1>📍 Entrega</h1>
        <p>Olá, <strong><?php echo $nome_usuario; ?></strong>! Onde deseja receber seu pedido?</p>

        <form action="/app/Controllers/salvar_pedido.php" method="POST">
            
            <div style="margin: 20px 0; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
                <label style="cursor:pointer; display: block; margin-bottom: 10px;">
                    <input type="radio" name="opcao_endereco" value="padrao" checked onclick="toggleEndereco('padrao')">
                    <strong>Usar meu endereço cadastrado:</strong><br>
                    <span style="color: #666; margin-left: 20px;"><?php echo $endereco_padrao; ?></span>
                    <input type="hidden" name="endereco_final_padrao" value="<?php echo $endereco_padrao; ?>">
                </label>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">

                <label style="cursor:pointer; display: block;">
                    <input type="radio" name="opcao_endereco" value="novo" onclick="toggleEndereco('novo')">
                    <strong>Entregar em outro endereço</strong>
                </label>

                <div id="campo_novo_endereco" style="display: none; margin-top: 15px; margin-left: 20px; text-align: left;">
                    <p style="font-weight: bold; margin-bottom: 10px; color: #333;">Preencha o novo endereço:</p>
                    
                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <div style="flex: 3;">
                            <label style="display:block; font-size: 14px; margin-bottom: 5px; color: #333;">Rua/Avenida</label>
                            <input type="text" id="nova_rua" name="nova_rua" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display:block; font-size: 14px; margin-bottom: 5px; color: #333;">Número</label>
                            <input type="text" id="novo_numero" name="novo_numero" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label style="display:block; font-size: 14px; margin-bottom: 5px; color: #333;">Bairro</label>
                            <input type="text" id="novo_bairro" name="novo_bairro" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display:block; font-size: 14px; margin-bottom: 5px; color: #333;">Cidade</label>
                            <input type="text" id="nova_cidade" name="nova_cidade" value="Pelotas" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <div style="text-align: right;">
                <a href="carrinho.php" style="margin-right: 15px; color: #666;">Voltar ao Carrinho</a>
                <button type="submit" class="btn-finalizar" style="max-width: 200px;">CONFIRMAR E FINALIZAR</button>
            </div>
        </form>
    </div>
</body>
</html>