<?php
require_once '../Config/Database.php';
require_once '../Models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $usuario_model = new Usuario($db);

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];

    // 2. Criptografa a senha para o banco de dados
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // 3. Tenta salvar no banco
    if ($usuario_model->cadastrar($nome, $email, $senha_hash, $telefone, $rua, $numero, $bairro, $cidade)) {
        
        echo "<script>
                alert('Conta criada com sucesso! Faça login para continuar.');
                window.location.href = '/Projeto/app/Views/login.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao criar conta. Talvez o email já esteja em uso.');
                history.back();
              </script>";
    }
}
?>