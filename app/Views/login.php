<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TDY Morangos</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body class="login-page">

    <header class="main-header">
        <div class="header-content">
            <img src="../../public/img/morango1.png" alt="Logo" class="logo-img">
            <h1>TDY MORANGOS</h1>
            <img src="../../public/img/morango1.png" alt="Logo" class="logo-img">
        </div>
    </header>

    <main class="login-container">
        <div class="login-card">
            <h2>BEM VINDO</h2>
            
            <form action="../Controllers/processa_login.php" method="POST" class="login-form">
                
                <div class="form-group">
                    <label for="email">USUÁRIO (E-MAIL)</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="form-group">
                    <label for="senha">SENHA</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="btn-entrar">ENTRAR</button>
                
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; TDY Morangos - Entregas de Sexta-feira</p>
    </footer>

</body>
</html>