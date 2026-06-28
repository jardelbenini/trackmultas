<?php

class StatusPagamento
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM status_pagamento ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM status_pagamento WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function cadastrar($nome, $cor)
    {
        $stmt = $this->pdo->prepare("INSERT INTO status_pagamento (nome, cor) VALUES (:nome, :cor)");
        return $stmt->execute([':nome' => $nome, ':cor' => $cor]);
    }

    public function atualizar($id, $nome, $cor)
    {
        $stmt = $this->pdo->prepare("UPDATE status_pagamento SET nome = :nome, cor = :cor WHERE id = :id");
        return $stmt->execute([':id' => $id, ':nome' => $nome, ':cor' => $cor]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM status_pagamento WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
