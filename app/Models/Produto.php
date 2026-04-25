// Dentro da classe Produto em app/Models/Produto.php

public function buscarAlertasPrevisao() {
    // SQL: Busca produtos INDISPONÍVEIS onde a data de previsão já passou ou é hoje
    $query = "SELECT * FROM " . $this->table_name . " 
              WHERE disponivel_na_semana = 0 
              AND previsao_disponibilidade <= CURRENT_DATE 
              AND previsao_disponibilidade IS NOT NULL";
              
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function listarTodos() {
    $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome_fruta ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}