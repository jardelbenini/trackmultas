<?php

class Responsabilidade
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM responsabilidades ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM responsabilidades WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function cadastrar($nome)
    {
        $stmt = $this->pdo->prepare("INSERT INTO responsabilidades (nome) VALUES (:nome)");
        return $stmt->execute([':nome' => $nome]);
    }

    public function atualizar($id, $nome)
    {
        $stmt = $this->pdo->prepare("UPDATE responsabilidades SET nome = :nome WHERE id = :id");
        return $stmt->execute([':id' => $id, ':nome' => $nome]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM responsabilidades WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
