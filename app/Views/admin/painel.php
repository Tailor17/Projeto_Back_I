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
    <title>Painel Administrativo - TDY Morangos</title>
    <link rel="stylesheet" href="../../../public/css/style.css">
    <link rel="stylesheet" href="../../../public/css/admin.css"> </head>
    <style>
        .btn-login { display: inline-block; margin-left: 12px; color: white; border: 1px solid white; padding: 8px 12px; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .btn-login:hover { background: white; color: #E53935; }
    </style>
<body>

    <header class="main-header">
        <div class="header-content">
            <img src="../../../public/img/morango1.png" alt="Logo" class="logo-img">
            <h1>PAINEL DO ADMINISTRADOR</h1>
                <div class="user-info" style="position: absolute; top: 20px; left: 20px; display: flex; align-items: center; gap: 10px;">
                <?php if (!empty($_SESSION['usuario_nome'])): ?>
                    <span>Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
                    <a href="/app/Controllers/logout.php" class="btn-login">Sair</a>
                <?php else: ?>
                    <span>Olá, visitante</span>
                    <a href="/app/Views/login.php" class="btn-login">Login</a>
                <?php endif; ?>
            </div>
        
        <a href="/index.php" class="btn-login" style="position: absolute; top: 20px; right: 20px;">Voltar para Vitrine</a>
            
        </div>
    </header>

    <main class="admin-container">
        
    
        <?php if (!empty($alertas)): ?>
        <section class="alert-section">
            <div class="alert-card">
                <h3>⚠️ Notificações de Estoque</h3>
                <ul>
                    <?php foreach ($alertas as $alerta): ?>
                        <li>O prazo de <strong><?php echo $alerta['nome_fruta']; ?></strong> expirou em <?php echo date('d/m/Y', strtotime($alerta['previsao_disponibilidade'])); ?>. Atualize o status!</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <?php endif; ?>

        <section class="action-grid">
            
            <div class="card-action">
                <h3>Cardápio da Semana</h3>
                <p>Selecione os produtos que estarão disponíveis para os clientes.</p>
                <a href="/app/Controllers/gerenciar_semana.php" class="btn-admin">Gerenciar Disponibilidade</a>
            </div>

            <div class="card-action">
                <h3>Produtos</h3>
                <p>Cadastre novas frutas, altere preços e fotos.</p>
                <a href="/app/Controllers/listar_produtos.php" class="btn-admin">Produtos Cadastrados</a>
            </div>


            <div class="card-action">
                <h3>Gerenciar Pedidos</h3>
                <p>Veja os pedidos realizados.</p>
                <a href="/app/Controllers/listar_pedidos.php" class="btn-admin">Ver Pedidos</a>
            </div>

            <div class="card-action">
                <h3>🗓️ Previsão de Safra</h3>
                <p>Definir datas de retorno.</p>
                <a href="/app/Controllers/carregar_previsoes.php" class="btn-admin">Gerenciar Datas</a>
            </div>       

        </section>
    </main>

    <footer class="main-footer">
        <p>&copy; TDY Morangos - Painel de Controle</p>
    </footer>
</body>
</html>