<?php
// 1. Inicia a sessão: Isso é OBRIGATÓRIO para o sistema "lembrar" quem está logado
session_start(); 

// 2. Traz os arquivos de configuração e a planta (Model) do Usuário
require_once '../Config/Database.php';
require_once '../Models/Usuario.php';

// 3. Verifica se os dados realmente vieram do clique do botão (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Conecta com o banco de dados (usando a classe PDO que criamos)
    $database = new Database();
    $db = $database->getConnection();

    // Instancia um novo objeto Usuário, passando a conexão do banco para ele
    $usuario = new Usuario($db);

    // Pega os dados que vieram do formulário HTML
    $email_digitado = $_POST['email'];
    $senha_digitada = $_POST['senha'];

    // 4. A Mágica Acontece: Chama o método login() que criamos no Model
    if ($usuario->login($email_digitado, $senha_digitada)) {
        
        // Se o login for true (senha bateu com o hash no banco), salvamos os dados na sessão
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nome'] = $usuario->nome;
        $_SESSION['tipo_usuario'] = $usuario->tipo_usuario;

        // 5. Redirecionamento Inteligente baseado no nível de acesso
        if ($usuario->tipo_usuario == 1) {
            // É o Dono (Admin) -> Vai para o Painel de Controle
            header("Location: ../Views/admin/painel.php");
        } else {
            // É Cliente (0) -> Vai para a Vitrine de Frutas
            header("Location: /index.php");
        }
        exit; // Sempre use exit após um header("Location") para parar a execução do script
        
    } else {
        // Se o login retornar false (e-mail ou senha errados), mostra erro e volta pro login
        echo "<script>
                alert('E-mail ou senha incorretos! Tente novamente.');
                window.location.href = '../Views/login.php';
              </script>";
    }
} else {
    // Se alguém tentar acessar 'processa_login.php' digitando direto no navegador, é expulso
    header("Location: ../Views/login.php");
    exit;
}
?>