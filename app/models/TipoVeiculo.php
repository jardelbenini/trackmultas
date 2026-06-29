<?php

class TipoVeiculo
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM tipos_veiculos ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tipos_veiculos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function cadastrar($nome)
    {
        $stmt = $this->pdo->prepare("INSERT INTO tipos_veiculos (nome) VALUES (:nome)");
        return $stmt->execute([':nome' => $nome]);
    }

    public function atualizar($id, $nome)
    {
        $stmt = $this->pdo->prepare("UPDATE tipos_veiculos SET nome = :nome WHERE id = :id");
        return $stmt->execute([':id' => $id, ':nome' => $nome]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE tipo_veiculo_id = :id");
        $stmt->execute([':id' => $id]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("Não é possível excluir o tipo de veículo, pois existem veículos vinculados a ele.");
        }

        $stmt = $this->pdo->prepare("DELETE FROM tipos_veiculos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
