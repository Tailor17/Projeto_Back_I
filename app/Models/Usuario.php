<?php

class Usuario {
    private $conn;
    private $table_name = "Usuarios";

    public $id;
    public $nome;
    public $email;
    public $senha;
    public $tipo_usuario;
    
    public $telefone;
    public $rua;
    public $numero;
    public $bairro;
    public $cidade;

    public function __construct($db) {
        $this->conn = $db;
    }

    // =======================================================
    // MÉTODO 1: CADASTRAR (Novo cliente)
    // =======================================================
    public function cadastrar($nome, $email, $senha_hash, $telefone, $rua, $numero, $bairro, $cidade) {
        
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, email, senha, telefone, rua, numero, bairro, cidade, tipo_usuario) 
                  VALUES (:nome, :email, :senha, :telefone, :rua, :numero, :bairro, :cidade, 2)";
        
        $stmt = $this->conn->prepare($query);
        
        
        $nome_limpo = htmlspecialchars(strip_tags($nome));
        
        $stmt->bindParam(':nome', $nome_limpo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':rua', $rua);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        
        return $stmt->execute();
    }

    // =======================================================
    // MÉTODO 2: FAZER LOGIN (SELECT e Validação)
    // =======================================================
    public function login($email_digitado, $senha_digitada) {
        $query = "SELECT id, nome, senha, tipo_usuario, telefone, rua, numero, bairro, cidade 
                  FROM " . $this->table_name . " 
                  WHERE email = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email_digitado);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($senha_digitada, $row['senha'])) {
                
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                $this->email = $row['email'];
                $this->tipo_usuario = $row['tipo_usuario'];
                $this->telefone = $row['telefone'] ?? '';
                $this->rua = $row['rua'] ?? '';
                $this->numero = $row['numero'] ?? '';
                $this->bairro = $row['bairro'] ?? '';
                $this->cidade = $row['cidade'] ?? '';
                
                return true; 
            }
        }
        return false; 
    }

    // =======================================================
    // BUSCAR USUÁRIO POR ID (Para pegar o endereço)
    // =======================================================
    public function buscarPorId($id) {
        $query = "SELECT nome, email, telefone, rua, numero, bairro, cidade 
                  FROM " . $this->table_name . " 
                  WHERE id = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    // =======================================================
    // Atualizar o perfil do usuário
    // =======================================================

public function atualizarPerfil($id, $nome, $email, $telefone, $rua, $numero, $bairro, $cidade, $senha = null) {
    $query = "UPDATE " . $this->table_name . " 
              SET nome = :nome, email = :email, telefone = :telefone, rua = :rua, 
                  numero = :numero, bairro = :bairro, cidade = :cidade";
    
    if ($senha) {
        $query .= ", senha = :senha";
    }

    $query .= " WHERE id = :id";
    
    $stmt = $this->conn->prepare($query);
    
    $nome_limpo = htmlspecialchars(strip_tags($nome));
    
    $stmt->bindParam(':nome', $nome_limpo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':rua', $rua);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':id', $id);
    
    if ($senha) {
        $stmt->bindParam(':senha', $senha);
    }
    
    return $stmt->execute();
}

}
?>
