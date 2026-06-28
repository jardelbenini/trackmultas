<?php

class Orgao
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function listar()
    {
        $stmt = $this->pdo->query("SELECT * FROM orgaos ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orgaos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function verificarCodigoExistente($codigo, $id = null)
    {
        $sql = "SELECT id FROM orgaos WHERE codigo = :codigo";
        $params = [':codigo' => $codigo];
        if ($id) {
            $sql .= " AND id != :id";
            $params[':id'] = $id;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }

    public function cadastrar($dados)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orgaos (codigo, nome, sigla) VALUES (:codigo, :nome, :sigla)");
        return $stmt->execute([
            ':codigo' => empty($dados['codigo']) ? null : $dados['codigo'],
            ':nome'   => $dados['nome'],
            ':sigla'  => empty($dados['sigla']) ? null : $dados['sigla']
        ]);
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare("UPDATE orgaos SET codigo = :codigo, nome = :nome, sigla = :sigla WHERE id = :id");
        return $stmt->execute([
            ':id'     => $id,
            ':codigo' => empty($dados['codigo']) ? null : $dados['codigo'],
            ':nome'   => $dados['nome'],
            ':sigla'  => empty($dados['sigla']) ? null : $dados['sigla']
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM orgaos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
