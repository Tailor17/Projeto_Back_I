<?php

class Database {
    // Configurações do Banco de Dados
    private $host = 'localhost';
    private $port = '3307'; 
    private $db_name = 'projeto'; 
    private $username = 'root';   
    private $password = 'senha_root_secreta';       
    private $conn;

    // Método para conectar ao banco
    public function getConnection() {
        $this->conn = null;

        try {
            // Atualizamos a string de conexão (DSN) para incluir a porta
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8";
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $exception) {
            echo "Erro de conexão com o banco de dados: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>