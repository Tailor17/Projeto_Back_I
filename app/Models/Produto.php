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

    // [1] CADASTRAR
    public function cadastrar() {
        $query = "INSERT INTO " . $this->table_name . " SET nome_fruta = :nome, preco = :preco, foto_produto = :foto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $this->nome_fruta);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":foto", $this->foto_produto);
        return $stmt->execute();
    }

    // [2] LISTAR TODOS
    public function listarTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome_fruta ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [3] BUSCAR POR ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // [4] ATUALIZAR (Update)
    public function atualizar($id, $nome_fruta, $preco, $foto_produto) {
        
        // A query limpa, atualizando os 3 campos sempre (já que o Controller garante qual é a foto certa)
        $query = "UPDATE " . $this->table_name . " SET nome_fruta = :nome, preco = :preco, foto_produto = :foto WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Substituindo as tags pelas variáveis que vieram do Controller
        $stmt->bindParam(':nome', $nome_fruta);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':foto', $foto_produto);

        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // [5] EXCLUIR (Delete)
    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    // [6] ALERTAS DE PREVISÃO (Lógica Extra) (ainda não implementada no Controller)
    public function buscarAlertasPrevisao() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE disponivel_na_semana = 0 AND previsao_disponibilidade <= CURRENT_DATE AND previsao_disponibilidade IS NOT NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// =======================================================
    // MÉTODO 7: ZERAR TODA A DISPONIBILIDADE DA SEMANA E PREVISÃO
    // =======================================================
    public function zerarDisponibilidade() {
        // AUTOMAÇÃO: Tira do cardápio (0) E já coloca status de falta ('Sem previsão')
        $query = "UPDATE " . $this->table_name . " SET disponivel_na_semana = 0, previsao = 'Sem previsão'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    // =======================================================
    // MÉTODO 8: ATIVAR PRODUTOS SELECIONADOS NA SEMANA E PREVISÃO
    // =======================================================
    public function atualizarDisponibilidade($ids_array) {
        if(empty($ids_array)) return true;

        $placeholders = implode(',', array_fill(0, count($ids_array), '?'));

        // AUTOMAÇÃO: Coloca no cardápio (1) E limpa o status de falta ('Disponível')
        $query = "UPDATE " . $this->table_name . " SET disponivel_na_semana = 1, previsao = 'Disponível' WHERE id IN ($placeholders)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute($ids_array);
    }

    // =======================================================
    // MÉTODO 9: LISTAR APENAS PRODUTOS DISPONÍVEIS NA SEMANA
    // =======================================================
    public function listarDisponiveisSemana() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE disponivel_na_semana = 1 ORDER BY nome_fruta ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // =======================================================
    // MÉTODO 10: LISTAR APENAS PRODUTOS INDISPONÍVEIS / COM PREVISÃO
    // =======================================================
    public function listarIndisponiveis() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE previsao != 'Disponível'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =======================================================
    // MÉTODO 11: ATUALIZAR A PREVISÃO NO PAINEL ADMIN
    // =======================================================
    public function atualizarPrevisao($id, $nova_previsao) {
        $query = "UPDATE " . $this->table_name . " SET previsao = :previsao WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':previsao', $nova_previsao);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // =======================================================
    // MÉTODO 12: INTERRUPTOR AUTÔNOMO DE VENDAS
    // =======================================================
    public function alternarDisponibilidade($id, $previsao_atual) {
        // A regra de negócio autônoma que você definiu:
        if ($previsao_atual == 'Disponível') {
            $novo_status = 'Sem previsão'; // Sai da vitrine e vai para a aba de espera
        } else {
            $novo_status = 'Disponível'; // Volta para a vitrine principal
        }

        $query = "UPDATE " . $this->table_name . " SET previsao = :novo_status WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':novo_status', $novo_status);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // =======================================================
    // MÉTODO 14: LISTAR APENAS PRODUTOS FORA DO CARDÁPIO
    // =======================================================
    public function listarForaDoCardapio() {
        $query = "SELECT id, nome_fruta, previsao FROM " . $this->table_name . " WHERE disponivel_na_semana = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    }