<?php

class CategoriaInfracao
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM categorias_infracoes ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categorias_infracoes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function cadastrar($dados)
    {
        $stmt = $this->pdo->prepare("INSERT INTO categorias_infracoes (nome) VALUES (:nome)");
        return $stmt->execute([
            ':nome' => $dados['nome']
        ]);
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare("UPDATE categorias_infracoes SET nome = :nome WHERE id = :id");
        return $stmt->execute([
            ':id'   => $id,
            ':nome' => $dados['nome']
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM categorias_infracoes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
