<?php

class Usuario {
    // Conexão com o banco de dados e nome da tabela
    private $conn;
    private $table_name = "Usuarios";

    // Propriedades do objeto (idênticas às colunas do banco)
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $endereco_padrao;
    public $foto_perfil;
    public $tipo_usuario;

    // O construtor recebe a conexão do banco de dados (que fizemos no Database.php)
    public function __construct($db) {
        $this->conn = $db;
    }

    // =======================================================
    // MÉTODO 1: CADASTRAR (INSERT)
    // =======================================================
    public function cadastrar() {
        // Query SQL utilizando "Named Parameters" (:nome, :email) para segurança contra SQL Injection
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nome = :nome, email = :email, senha = :senha, tipo_usuario = :tipo_usuario";

        // Prepara a query (Exigência do Requisito 5)
        $stmt = $this->conn->prepare($query);

        // Limpa os dados para evitar injeção de scripts maliciosos (XSS)
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        
        // Gera o Hash da senha (Exigência do Requisito 4)
        $senha_hash = password_hash($this->senha, PASSWORD_BCRYPT);

        // Faz o bind (vínculo) dos valores aos parâmetros da query
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $senha_hash); // Salvamos o hash, NUNCA a senha em texto puro
        $stmt->bindParam(":tipo_usuario", $this->tipo_usuario);

        // Executa a query (Exigência do Requisito 5)
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // =======================================================
    // MÉTODO 2: FAZER LOGIN (SELECT e Validação)
    // =======================================================
    public function login($email_digitado, $senha_digitada) {
        // Busca o usuário pelo e-mail
        $query = "SELECT id, nome, senha, tipo_usuario FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email_digitado);
        $stmt->execute();

        // Verifica se encontrou algum e-mail correspondente
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifica se a senha digitada bate com o Hash salvo no banco (password_verify)
            if(password_verify($senha_digitada, $row['senha'])) {
                
                // Se a senha estiver correta, preenche as propriedades do objeto com os dados do banco
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                $this->tipo_usuario = $row['tipo_usuario'];
                
                return true; // Login com sucesso!
            }
        }
        return false; // Falha no login (e-mail ou senha incorretos)
    }
}
?>