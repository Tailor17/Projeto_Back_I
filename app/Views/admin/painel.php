<?php
session_start();
// Proteção básica: Se não for ADM, volta pro login
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
<body>

    <header class="main-header">
        <div class="header-content">
            <img src="../../../public/img/morango1.png" alt="Logo" class="logo-img">
            <h1>PAINEL DO ADMINISTRADOR</h1>
            <div class="user-info">
                <span>Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
                <a href="../../Controllers/logout.php" class="btn-sair-link">Sair</a>
            </div>
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
                <h3>Pedidos da Semana</h3>
                <p>Veja quem comprou e prepare as entregas da semana.</p>
                <a href="../Controllers/gerar_relatorio.php" class="btn-admin btn-download">Baixar Pedidos (CSV)</a>
            </div>

            <div class="card-action">
                <h3>Gerenciar Pedidos</h3>
                <p>Veja os pedidos realizados.</p>
                <a href="/app/Controllers/listar_pedidos.php" class="btn-admin">Ver Pedidos</a>
            </div>

        </section>
    </main>

    <footer class="main-footer">
        <p>&copy; TDY Morangos - Painel de Controle</p>
    </footer>
</body>
</html>