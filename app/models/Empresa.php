<?php

class Empresa
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM empresas ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM empresas WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function buscarPorCnpj($cnpj, $ignorarId = null)
    {
        if ($ignorarId) {
            $stmt = $this->pdo->prepare("SELECT * FROM empresas WHERE cnpj = :cnpj AND id != :id");
            $stmt->execute([':cnpj' => $cnpj, ':id' => $ignorarId]);
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM empresas WHERE cnpj = :cnpj");
            $stmt->execute([':cnpj' => $cnpj]);
        }
        return $stmt->fetch();
    }

    public function cadastrar($nome, $cnpj = null)
    {
        $stmt = $this->pdo->prepare("INSERT INTO empresas (nome, cnpj) VALUES (:nome, :cnpj)");
        return $stmt->execute([
            ':nome' => $nome,
            ':cnpj' => $cnpj ?: null
        ]);
    }

    public function atualizar($id, $nome, $cnpj = null)
    {
        $stmt = $this->pdo->prepare("UPDATE empresas SET nome = :nome, cnpj = :cnpj WHERE id = :id");
        return $stmt->execute([
            ':id'   => $id,
            ':nome' => $nome,
            ':cnpj' => $cnpj ?: null
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM empresas WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
