<?php

class Setor
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM setores ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM setores WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function cadastrar($nome)
    {
        $stmt = $this->pdo->prepare("INSERT INTO setores (nome) VALUES (:nome)");
        return $stmt->execute([':nome' => $nome]);
    }

    public function atualizar($id, $nome)
    {
        $stmt = $this->pdo->prepare("UPDATE setores SET nome = :nome WHERE id = :id");
        return $stmt->execute([
            ':id'   => $id,
            ':nome' => $nome
        ]);
    }

    public function excluir($id)
    {
        // Verifica se existem motoristas associados
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM motoristas WHERE setor_id = :id");
        $stmt->execute([':id' => $id]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("Não é possível excluir o setor, pois existem motoristas vinculados a ele.");
        }

        $stmt = $this->pdo->prepare("DELETE FROM setores WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
