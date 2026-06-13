<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos - TDY Morangos</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
        /* Estilos específicos para a tabela ficarem bonitos no seu padrão */
        .table-container { max-width: 1000px; margin: 40px auto; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #E53935; color: white; }
        .img-miniatura { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
        .btn-novo { display: inline-block; background: #2e7d32; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .btn-novo:hover { background: #1b5e20; }
        .btn-acao { padding: 5px 10px; border-radius: 4px; text-decoration: none; color: white; font-size: 14px; margin-right: 5px; }
        .btn-editar { background-color: #f39c12; }
        .btn-excluir { background-color: #c0392b; }
    </style>
</head>
<body class="login-page">

    <header class="main-header">
        <div class="header-content">
            <h1>GERENCIAR PRODUTOS</h1>
        </div>
    </header>

    <main class="table-container">
        
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Frutas Cadastradas</h2>
            <a href="/app/Views/admin/produto_cadastrar.php" class="btn-novo">+ Novo Produto</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nome do Produto</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lista_produtos)): ?>
                    <?php foreach ($lista_produtos as $item): ?>
                    <tr>
                        <td>
                            <img src="/public/uploads/produtos/<?php echo $item['foto_produto']; ?>" alt="Foto" class="img-miniatura">
                        </td>
                        <td><?php echo $item['nome_fruta']; ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="/app/Controllers/carregar_edicao.php?id=<?php echo $item['id']; ?>" class="btn-acao btn-editar">Editar</a>
                            <a href="/app/Controllers/excluir_produto.php?id=<?php echo $item['id']; ?>" class="btn-acao btn-excluir" onclick="return confirm('Tem certeza que deseja apagar esta fruta do sistema?');">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Nenhum produto cadastrado ainda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="/app/Views/admin/painel.php" style="display:inline-block; margin-top:20px; color:#E53935; text-decoration:none; font-weight:bold;">← Voltar ao Painel</a>

    </main>
</body>
</html>