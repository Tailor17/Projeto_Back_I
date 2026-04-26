<?php

class Produto {
    private $conn;
    private $table_name = "Produtos";

    // Propriedades
    public $id;
    public $nome_fruta;
    public $preco;
    public $disponivel_na_semana;
    public $foto_produto;
    public $previsao_disponibilidade;

    public function __construct($db) {
        $this->conn = $db;
    }

    // [1] CADASTRAR (Create)
    public function cadastrar() {
        $query = "INSERT INTO " . $this->table_name . " SET nome_fruta = :nome, preco = :preco, foto_produto = :foto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $this->nome_fruta);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":foto", $this->foto_produto);
        return $stmt->execute();
    }

    // [2] LISTAR TODOS (Read - All)
    public function listarTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome_fruta ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [3] BUSCAR POR ID (Read - One)
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [4] ATUALIZAR (Update)
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " SET nome_fruta = :nome, preco = :preco";
        if (!empty($this->foto_produto)) { $query .= ", foto_produto = :foto"; }
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $this->nome_fruta);
        $stmt->bindParam(':preco', $this->preco);
        $stmt->bindParam(':id', $this->id);
        if (!empty($this->foto_produto)) { $stmt->bindParam(':foto', $this->foto_produto); }
        return $stmt->execute();
    }

    // [5] EXCLUIR (Delete)
    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    // [6] ALERTAS DE PREVISÃO (Lógica Extra)
    public function buscarAlertasPrevisao() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE disponivel_na_semana = 0 AND previsao_disponibilidade <= CURRENT_DATE AND previsao_disponibilidade IS NOT NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// =======================================================
    // MÉTODO 7: ZERAR TODA A DISPONIBILIDADE DA SEMANA
    // =======================================================
    public function zerarDisponibilidade() {
        $query = "UPDATE " . $this->table_name . " SET disponivel_na_semana = 0";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    // =======================================================
    // MÉTODO 8: ATIVAR PRODUTOS SELECIONADOS NA SEMANA
    // =======================================================
    public function atualizarDisponibilidade($ids_array) {
        // Se nenhum produto foi marcado, não faz nada (já estão todos zerados)
        if(empty($ids_array)) return true;

        // Cria os "pontos de interrogação" para a query baseada na quantidade de produtos marcados
        // Exemplo: se marcou 3 frutas, fica "?, ?, ?"
        $placeholders = implode(',', array_fill(0, count($ids_array), '?'));

        $query = "UPDATE " . $this->table_name . " SET disponivel_na_semana = 1 WHERE id IN ($placeholders)";
        $stmt = $this->conn->prepare($query);

        // O PDO é inteligente e substitui os "?" pelos IDs que vieram no array
        return $stmt->execute($ids_array);
    }}