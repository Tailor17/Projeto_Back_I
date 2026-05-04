<?php
class Pedido {
    private $conn;
    private $table_name = "pedidos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // =======================================================
    // MÉTODO: SALVAR O CABEÇALHO DO PEDIDO
    // =======================================================
    public function criar($nome_cliente, $telefone_cliente, $valor_total, $endereco_entrega) {
        
        
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome_cliente, telefone_cliente, valor_total, endereco_entrega, data_pedido) 
                  VALUES (:nome, :telefone, :valor, :endereco, NOW())";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nome', $nome_cliente);
        $stmt->bindParam(':telefone', $telefone_cliente);
        $stmt->bindParam(':valor', $valor_total);
        $stmt->bindParam(':endereco', $endereco_entrega);
        
        if ($stmt->execute()) {
            // Retorna o ID que o banco acabou de gerar!
            return $this->conn->lastInsertId(); 
        }
        return false;
    }

    // =======================================================
    // MÉTODO: SALVAR CADA FRUTA DO CARRINHO (ITENS)
    // =======================================================
    public function adicionarItem($pedido_id, $produto_id, $quantidade, $preco_no_momento) {
        $query = "INSERT INTO itens_pedido 
                  (pedido_id, produto_id, quantidade, preco_no_momento) 
                  VALUES (:pedido_id, :produto_id, :quantidade, :preco)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':pedido_id', $pedido_id);
        $stmt->bindParam(':produto_id', $produto_id);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':preco', $preco_no_momento);
        
        return $stmt->execute();
    }
    // =======================================================
    // MÉTODO: LISTAR TODOS OS PEDIDOS (Mais recentes primeiro)
    // =======================================================
    public function listarTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY data_pedido DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =======================================================
    // MÉTODO: BUSCAR OS ITENS DE UM PEDIDO ESPECÍFICO
    // =======================================================
    public function buscarItens($pedido_id) {
        $query = "SELECT i.quantidade, i.preco_no_momento, p.nome_fruta 
                  FROM itens_pedido i 
                  INNER JOIN Produtos p ON i.produto_id = p.id 
                  WHERE i.pedido_id = :pedido_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pedido_id', $pedido_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =======================================================
    // MÉTODO: ATUALIZAR STATUS DO PEDIDO
    // =======================================================
    public function atualizarStatus($id, $novo_status) {
        $query = "UPDATE pedidos SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $novo_status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>